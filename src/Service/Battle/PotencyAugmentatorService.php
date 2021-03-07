<?php

namespace App\Service\Battle;

use App\Entity\Game;
use App\Entity\GameCharacter;
use App\Entity\PotencyAugmentator;
use App\Service\GameEnv;
use Doctrine\ORM\EntityManagerInterface;

class PotencyAugmentatorService
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

    public function extractPotencyAugmentatorsValueFromEffect($effect, GameCharacter $launcher)
    {
        //If there is no augmentator, we just return value
        if(count($effect->getPotencyAugmentator()) == 0)
            return null;

        //We set data who we need
        $baseValue = $effect->getValue();
        $augmentators = $effect->getPotencyAugmentator();
        $augmentatorsValues = [];

        /** @var PotencyAugmentator $augmentator */
        foreach($augmentators as $augmentator) {

            //We get launcher attribute
            $launcherAttribute = $launcher->seekCharacterAttribute($augmentator->getAttribute());
            if($launcherAttribute !== null) {

                //---------------------------------------
                //---------- ADD TO POTENCY -------------
                //---------------------------------------

                if($augmentator->getType() === PotencyAugmentator::TYPE_ADD || $augmentator->getType() === PotencyAugmentator::TYPE_ADD_SOOTHE) {

                    //We get attribute value
                    $attributeValue = $launcherAttribute->getFinalValue();
                    if($augmentator->getType() === PotencyAugmentator::TYPE_ADD_SOOTHE)
                        $attributeValue = $attributeValue / 3;

                    //We check if it's > to ceiling
                    if($augmentator->getPercentCeiling() !== null && $attributeValue > ($baseValue * $augmentator->getPercentCeiling() / 100))
                        $attributeValue = $baseValue * $augmentator->getPercentCeiling() / 100;

                    //We add to augmentators array
                    $augmentatorsValues[] = $attributeValue;

                }

                //---------------------------------------
                //-------- MULTIPLY POTENCY -------------
                //---------------------------------------

                if($augmentator->getType() === PotencyAugmentator::TYPE_MULTIPLY || $augmentator->getType() === PotencyAugmentator::TYPE_MULTIPLY_SOOTHE) {

                    //We get attribute value
                    $attributeValue = $launcherAttribute->getFinalValue();
                    if($augmentator->getType() === PotencyAugmentator::TYPE_MULTIPLY_SOOTHE)
                        $attributeValue = $attributeValue / 3;

                    //We multiply potency to attribute value
                    $finalValue = $baseValue * $attributeValue;
                    $augmentatorValue = $finalValue - $baseValue;

                    //We check if it's > to ceiling or < to 0
                    if($augmentator->getPercentCeiling() !== null && $augmentatorValue > ($baseValue * $augmentator->getPercentCeiling() / 100))
                        $augmentatorValue = $baseValue * $augmentator->getPercentCeiling() / 100;
                    elseif($augmentatorValue < 0)
                        $augmentatorValue = 0;

                    //We add to augmentators array
                    $augmentatorsValues[] = $augmentatorValue;

                }

            }

        }

        //We parse augmentator values and return final value
        $finalAugmentatorsValue = 0;
        foreach($augmentatorsValues as $value) {
            $finalAugmentatorsValue = $finalAugmentatorsValue + $value;
        }

        //We return rounded result
        return round($finalAugmentatorsValue);

    }

}