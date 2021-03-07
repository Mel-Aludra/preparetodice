<?php

namespace App\Service;

use App\Entity\AttributeAlteration;
use App\Entity\CharacteristicCalculation;
use App\Entity\Game;
use App\Entity\GameCharacter;
use App\Entity\ResourceAlteration;

class CharacteristicsCalculator
{

    private Game $game;
    private array $characteristicsCalculation = [];

    /**
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function getGame() :Game { return $this->game; }

    /**
     * Unique function calculating characteristics (no calculation allowed except in this service)
     * @param GameCharacter $gameCharacter
     */
    public function applyCalculationToCharacter(GameCharacter $gameCharacter)
    {

        //We get an array of each element, in these array, characteristics alterations will be stocked
        $attributesAlterations = ["passives" => [], "gears" => [], "statusEffects" => []];
        $resourcesAlterations = ["passives" => [], "gears" => [], "statusEffects" => []];

        //We get all elements
        foreach($gameCharacter->getCharacterPassives() as $characterPassive) {
            foreach($characterPassive->getPassive()->getAttributeAlterations() as $alteration)
                $attributesAlterations["passives"][] = $alteration;
            foreach($characterPassive->getPassive()->getResourceAlterations() as $alteration)
                $resourcesAlterations["passives"][] = $alteration;
        }
        foreach($gameCharacter->getEquippedGears() as $equippedGear) {
            if($equippedGear->getInventoryGear() !== null) {
                foreach($equippedGear->getInventoryGear()->getGear()->getAttributeAlterations() as $alteration)
                    $attributesAlterations["gears"][] = $alteration;
                foreach($equippedGear->getInventoryGear()->getGear()->getResourceAlterations() as $alteration)
                    $resourcesAlterations["gears"][] = $alteration;
            }
        }
        foreach($gameCharacter->getCharacterStatusEffects() as $characterStatusEffect) {
            foreach($characterStatusEffect->getStatusEffect()->getAttributeAlterations() as $alteration)
                $attributesAlterations["statusEffects"][] = $alteration;
            foreach($characterStatusEffect->getStatusEffect()->getResourceAlterations() as $alteration)
                $resourcesAlterations["statusEffects"][] = $alteration;
        }

        //We prepare attributes and resources
        $this->rationalizeCharacteristics($gameCharacter);
        foreach($gameCharacter->getCharacterAttributes() as $characterAttribute)
            $characterAttribute->setFinalValue($characterAttribute->getValue());
        foreach($gameCharacter->getCharacterResources() as $characterResource)
            $characterResource->setFinalValue($characterResource->getValue());

        //In first time, we calculate passives and gears elements
        $this->applyAttributeAlterationsToCharacter(1, $gameCharacter, array_merge($attributesAlterations["passives"], $attributesAlterations["gears"]));
        $this->applyResourceAlterationsToCharacter(1, $gameCharacter, array_merge($resourcesAlterations["passives"], $resourcesAlterations["gears"]));
        $this->rationalizeCharacteristics($gameCharacter);

        //In second time, we calculate status effects and attributes effects
        $this->applyAttributeAlterationsToCharacter(2, $gameCharacter, $attributesAlterations["statusEffects"]);
        $this->applyResourceAlterationsToCharacter(2, $gameCharacter, $resourcesAlterations["statusEffects"]);
        $this->rationalizeCharacteristics($gameCharacter);

        //Last, we apply attributes effects
        $this->applyAttributesEffects(3, $gameCharacter);
        $this->rationalizeCharacteristics($gameCharacter);

        //Return calculation mentions for save it
        return $this->characteristicsCalculation;

    }

    /**
     * @param int $poolNumber
     * @param GameCharacter $gameCharacter
     * @param array $attributeAlterations
     */
    private function applyAttributeAlterationsToCharacter(int $poolNumber, GameCharacter $gameCharacter, array $attributeAlterations)
    {
        //We stock a copy of character's attributes who will be used for basis calculations
        $basisAttributes = [];
        foreach($gameCharacter->getCharacterAttributes() as $characterAttribute) {
            $basisAttributes[] = clone $characterAttribute;
        }

        /** @var AttributeAlteration $attributeAlteration */
        foreach($attributeAlterations as $attributeAlteration) {

            $value = 0; //Set variable
            $calculationMention = "";

            //Two types of calculation : points or percent
            if($attributeAlteration->getCalculationType() === "points") {
                $value = $attributeAlteration->getValue();
                $calculationMention = $value . " points";
            } else {
                foreach($basisAttributes as $basisCharacterAttribute) {
                    if($basisCharacterAttribute->getAttribute()->getId() === $attributeAlteration->getAttribute()->getId()) {
                        $value = round($attributeAlteration->getValue() * $basisCharacterAttribute->getFinalValue() / 100);
                        $calculationMention = $value . " (" . $attributeAlteration->getValue() . "% of " . $basisCharacterAttribute->getFinalValue() . ")";
                    }
                }
            }

            //If value !== 0, we add or substract to attribute
            if($value !== 0) {
                foreach($gameCharacter->getCharacterAttributes() as $characterAttribute) {
                    if($characterAttribute->getAttribute()->getId() === $attributeAlteration->getAttribute()->getId()) {
                        if($attributeAlteration->getIsNegative()) {
                            $characterAttribute->setFinalValue($characterAttribute->getFinalValue() - $value);
                        } else {
                            $characterAttribute->setFinalValue($characterAttribute->getFinalValue() + $value);
                        }
                    }
                }

                //Add characteristic calculation
                $characteristicCalculation = new CharacteristicCalculation();
                $characteristicCalculation->setGameCharacter($gameCharacter);
                $characteristicCalculation->setValue($value);
                $characteristicCalculation->setIsNegative($attributeAlteration->getIsNegative());
                $characteristicCalculation->setCharacteristic($attributeAlteration->getAttribute()->getName());
                $characteristicCalculation->setPoolNumber($poolNumber);
                $characteristicCalculation->setSource($attributeAlteration->getSource());
                $characteristicCalculation->setCalculation($calculationMention);
                $this->characteristicsCalculation[] = $characteristicCalculation;

            }

        }

    }

    /**
     * @param int $poolNumber
     * @param GameCharacter $gameCharacter
     * @param array $resourceAlterations
     */
    private function applyResourceAlterationsToCharacter(int $poolNumber, GameCharacter $gameCharacter, array $resourceAlterations)
    {
        //We stock a copy of character's attributes who will be used for basis calculations
        $basisResources = [];
        foreach($gameCharacter->getCharacterResources() as $characterResource) {
            $basisResources[] = clone $characterResource;
        }

        /** @var ResourceAlteration $resourceAlteration */
        foreach($resourceAlterations as $resourceAlteration) {

            $value = 0; //Set variable
            $calculationMention = "";

            //Three types of calculation : points, percent current or percent max
            if($resourceAlteration->getCalculationType() === "points") {
                $value = $resourceAlteration->getValue();
                $calculationMention = $value . " points";
            } else {
                foreach($basisResources as $basisCharacterResource) {
                    if($basisCharacterResource->getResource()->getId() === $basisCharacterResource->getResource()->getId()) {
                        if($resourceAlteration->getCalculationType() === "percent_max") {
                            $value = round($resourceAlteration->getValue() * $basisCharacterResource->getFinalValue() / 100);
                            $calculationMention = $value . " (" . $resourceAlteration->getValue() . "% of " . $basisCharacterResource->getFinalValue() . ")";
                        } else {
                            $value = round($resourceAlteration->getValue() * $basisCharacterResource->getCurrentValue() / 100);
                            $calculationMention = $value . " (" . $resourceAlteration->getValue() . "% of " . $basisCharacterResource->getCurrentValue() . ")";
                        }
                    }
                }
            }

            //If value !== 0, we add or substract to resource
            if($value !== 0) {
                foreach($gameCharacter->getCharacterResources() as $characterResource) {
                    if($characterResource->getResource()->getId() === $resourceAlteration->getResource()->getId()) {
                        if($resourceAlteration->getIsNegative()) {
                            $characterResource->setFinalValue($characterResource->getFinalValue() - $value);
                        } else {
                            $characterResource->setFinalValue($characterResource->getFinalValue() + $value);
                        }
                    }
                }

                //Add characteristic calculation
                $characteristicCalculation = new CharacteristicCalculation();
                $characteristicCalculation->setGameCharacter($gameCharacter);
                $characteristicCalculation->setValue($value);
                $characteristicCalculation->setIsNegative($resourceAlteration->getIsNegative());
                $characteristicCalculation->setCharacteristic($resourceAlteration->getResource()->getName());
                $characteristicCalculation->setPoolNumber($poolNumber);
                $characteristicCalculation->setSource($resourceAlteration->getSource());
                $characteristicCalculation->setCalculation($calculationMention);
                $this->characteristicsCalculation[] = $characteristicCalculation;
            }

        }
    }

    /**
     * @param $poolNumber
     * @param GameCharacter $gameCharacter
     */
    private function applyAttributesEffects($poolNumber, GameCharacter $gameCharacter)
    {
        foreach($this->getGame()->getAttributes() as $gameAttribute) {
            foreach($gameAttribute->getAttributeEffects() as $attributeEffect) {
                foreach($gameCharacter->getCharacterResources() as $characterResource) {
                    if($characterResource->getResource()->getId() === $attributeEffect->getResource()->getId()) {
                        foreach($gameCharacter->getCharacterAttributes() as $characterAttribute) {
                            if($characterAttribute->getAttribute()->getId() === $attributeEffect->getAttribute()->getId()) {
                                $value = $characterAttribute->getFinalValue() * $attributeEffect->getValuePerPoint();
                                $characteristicCalculation = new CharacteristicCalculation();
                                $characteristicCalculation->setGameCharacter($gameCharacter);
                                $characteristicCalculation->setValue($value);
                                $characteristicCalculation->setIsNegative($attributeEffect->getIsNegative());
                                $characteristicCalculation->setCharacteristic($attributeEffect->getAttribute()->getName());
                                $characteristicCalculation->setPoolNumber($poolNumber);
                                $characteristicCalculation->setSource("Attribute native effect (" . $attributeEffect->getAttribute()->getName() . ")");
                                $characteristicCalculation->setCalculation($value . " (" . $characterAttribute->getFinalValue() . " x " . $attributeEffect->getValuePerPoint() . ")");
                                $this->characteristicsCalculation[] = $characteristicCalculation;
                                if($attributeEffect->getIsNegative()) {
                                    $characterResource->setFinalValue($characterResource->getFinalValue() - $value);
                                } else {
                                    $characterResource->setFinalValue($characterResource->getFinalValue() + $value);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Handle ceiling and floor
     * @param GameCharacter $gameCharacter
     */
    public function rationalizeCharacteristics(GameCharacter $gameCharacter)
    {
        foreach($gameCharacter->getCharacterResources() as $characterResource) {

            //Resource > Final value
            if($characterResource->getResource()->getMaximumValue() !== null && $characterResource->getFinalValue() > $characterResource->getResource()->getMaximumValue()) {
                $characterResource->setFinalValue($characterResource->getResource()->getMaximumValue());
            }
            elseif($characterResource->getFinalValue() < 0) {
                $characterResource->setFinalValue(0);
            }

            //Resource > Base value
            if($characterResource->getResource()->getMaximumValue() !== null && $characterResource->getValue() > $characterResource->getResource()->getMaximumValue()) {
                $characterResource->setValue($characterResource->getResource()->getMaximumValue());
            }
            elseif($characterResource->getValue() < 0) {
                $characterResource->setValue(0);
            }

            //Resource > Current value
            if($characterResource->getCurrentValue() > $characterResource->getFinalValue()) {
                $characterResource->setCurrentValue($characterResource->getFinalValue());
            }
            elseif($characterResource->getCurrentValue() < 0) {
                $characterResource->setCurrentValue(0);
            }

        }

        foreach($gameCharacter->getCharacterAttributes() as $characterAttribute) {

            //Attribute > Final value
            if($characterAttribute->getAttribute()->getMaximumValue() !== null && $characterAttribute->getFinalValue() > $characterAttribute->getAttribute()->getMaximumValue()) {
                $characterAttribute->setFinalValue($characterAttribute->getAttribute()->getMaximumValue());
            }
            elseif($characterAttribute->getFinalValue() < 0) {
                $characterAttribute->setFinalValue(0);
            }

            //Attribute > Base value
            if($characterAttribute->getAttribute()->getMaximumValue() !== null && $characterAttribute->getValue() > $characterAttribute->getAttribute()->getMaximumValue()) {
                $characterAttribute->setValue($characterAttribute->getAttribute()->getMaximumValue());
            }
            elseif($characterAttribute->getValue() < 0) {
                $characterAttribute->setValue(0);
            }

        }
    }


}