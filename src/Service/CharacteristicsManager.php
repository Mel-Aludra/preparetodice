<?php

namespace App\Service;

use App\Entity\CharacterAttribute;
use App\Entity\CharacterResource;
use App\Entity\Game;
use App\Entity\GameCharacter;
use Doctrine\ORM\EntityManagerInterface;

class CharacteristicsManager
{

    private Game $game;
    private EntityManagerInterface $manager;

    /**
     * @param GameEnv $gameEnv
     * @param EntityManagerInterface $manager
     */
    public function __construct(GameEnv $gameEnv, EntityManagerInterface $manager)
    {
        $this->game = $gameEnv->getGame();
        $this->manager = $manager;
    }

    public function getGame() :Game { return $this->game; }

    public function initData(GameCharacter $character)
    {
        $this->initAttributesForCharacter($character);
        $this->initResourcesForCharacter($character);
    }

    /**
     * Check all resources and attributes for all characters (case of resource or attribute update)
     */
    public function rebuildCharacteristics()
    {
        foreach($this->getGame()->getGameCharacters() as $character) {
            $this->initResourcesForCharacter($character);
            $this->initAttributesForCharacter($character);
            $this->calculateCharacteristics($character);
        }
    }

    /**
     * Check if resources exists - if not, we create it
     * @param GameCharacter $character
     */
    public function initResourcesForCharacter(GameCharacter $character)
    {
        foreach($this->getGame()->getResources() as $resource) {
            $characterResource = $character->seekCharacterResource($resource);
            if($characterResource === null) {
                $characterResource = new CharacterResource();
                $characterResource->setGameCharacter($character)
                    ->setValue(0)
                    ->setResource($resource)
                    ->setCurrentValue(0)
                    ->setFinalValue(0)
                    ->setActive(true);
                $character->addCharacterResource($characterResource);
            }
        }
    }

    /**
     * Check if attributes exists - if not, we create it
     * @param GameCharacter $character
     */
    public function initAttributesForCharacter(GameCharacter $character)
    {
        foreach($this->getGame()->getAttributes() as $attribute) {
            $characterAttribute = $character->seekCharacterAttribute($attribute);
            if($characterAttribute === null) {
                $characterAttribute = new CharacterAttribute();
                $characterAttribute->setGameCharacter($character)
                    ->setValue(0)
                    ->setAttribute($attribute)
                    ->setFinalValue(0)
                    ->setActive(true);
                $character->addCharacterAttribute($characterAttribute);
            }
        }
    }

    public function recalculateAllCharacteristics()
    {
        foreach($this->getGame()->getGameCharacters() as $character) {
            $this->calculateCharacteristics($character);
        }
    }

    public function calculateCharacteristics(GameCharacter $character)
    {
        //Wipe characteristics calculation
        foreach($character->getCharacteristicCalculations() as $characteristicCalculation) {
            $character->removeCharacteristicCalculation($characteristicCalculation);
            $this->manager->remove($characteristicCalculation);
        }

        //Characteristics calculator handle all calculation for characteristics but do not persist modifications
        $characteristicsCalculator = new CharacteristicsCalculator($this->getGame());
        $characteristicsCalculations = $characteristicsCalculator->applyCalculationToCharacter($character);

        //Perist
        foreach($character->getCharacterAttributes() as $characterAttribute)
            $this->manager->persist($characterAttribute);
        foreach($character->getCharacterResources() as $characterResource)
            $this->manager->persist($characterResource);
        foreach($characteristicsCalculations as $characteristicsCalculation) {
            $character->addCharacteristicCalculation($characteristicsCalculation);
            $this->manager->persist($characteristicsCalculation);
        }
        $this->manager->flush();
    }

    /**
     * @param $post
     * @param GameCharacter $gameCharacter
     */
    public function handleCharacteristicsPost($post, GameCharacter $gameCharacter)
    {

        //Resources post
        if(isset($post["character_resources"])) {
            foreach($post["character_resources"] as $characterResourceId => $values) {

                //Get resource and update values if not null
                $foundCharacterResource = null;

                //If character characteristic is null, then a hidden input give resource id
                if(isset($values["resourceId"])) {
                    foreach($gameCharacter->getCharacterResources() as $characterResource) {
                        if((int) $characterResource->getResource()->getId() === (int) $values["resourceId"])
                            $foundCharacterResource = $characterResource;
                    }
                }

                //Else we just get it
                else {
                    foreach($gameCharacter->getCharacterResources() as $characterResource) {
                        if((int) $characterResource->getId() === (int) $characterResourceId)
                            $foundCharacterResource = $characterResource;
                    }
                }

                //Update if not null
                if($foundCharacterResource !== null) {
                    $foundCharacterResource->setCurrentValue($values["current"]);
                    $foundCharacterResource->setValue($values["base"]);
                    $this->manager->persist($foundCharacterResource);
                }

            }
        }

        //Attributes post
        if(isset($post["character_attributes"])) {
            foreach($post["character_attributes"] as $characterAttributeId => $values) {

                //Get resource and update values if not null
                $foundCharacterAttribute = null;

                //If character characteristic is null, then a hidden input give resource id
                if(isset($values["attributeId"])) {
                    foreach($gameCharacter->getCharacterAttributes() as $characterAttribute) {
                        if((int) $characterAttribute->getAttribute()->getId() === (int) $values["attributeId"])
                            $foundCharacterAttribute = $characterAttribute;
                    }
                }

                //Else we just get it
                else {
                    foreach($gameCharacter->getCharacterAttributes() as $characterAttribute) {
                        if((int) $characterAttribute->getId() === (int) $characterAttributeId)
                            $foundCharacterAttribute = $characterAttribute;
                    }
                }

                //Update if not null
                if($foundCharacterAttribute !== null) {
                    $foundCharacterAttribute->setValue($values["base"]);
                    $this->manager->persist($foundCharacterAttribute);
                }

            }
        }

        if(isset($post["character_resources"]) || isset($post["character_attributes"])) {
            $this->calculateCharacteristics($gameCharacter);
        }

    }

}