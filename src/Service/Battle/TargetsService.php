<?php

namespace App\Service\Battle;

use App\Entity\Action;
use App\Entity\Game;
use App\Entity\Target;
use App\Service\GameEnv;
use Doctrine\ORM\EntityManagerInterface;

class TargetsService
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

    public function handleTargetsPost(Action $action, array $activeCharacters, $postTargets)
    {
        //Damage effects > for each, we parse characters and if one is targeted, we create new target
        foreach($action->getSkillDamageEffects() as $effect) {
            if(isset($postTargets["damageEffects"][$effect->getId()])) {
                foreach($activeCharacters as $character) {
                    if(isset($postTargets["damageEffects"][$effect->getId()][$character->getId()]) && $postTargets["damageEffects"][$effect->getId()][$character->getId()] === "true") {
                        $target = new Target();
                        $target->setGameCharacter($character);
                        $target->setSkillDamageEffect($effect);
                        $effect->addTarget($target);
                        $this->manager->persist($target);
                    }
                }
            }
        }

        //Heal effects > for each, we parse characters and if one is targeted, we create new target
        foreach($action->getSkillHealEffects() as $effect) {
            if(isset($postTargets["healEffects"][$effect->getId()])) {
                foreach($activeCharacters as $character) {
                    if(isset($postTargets["healEffects"][$effect->getId()][$character->getId()]) && $postTargets["healEffects"][$effect->getId()][$character->getId()] === "true") {
                        $target = new Target();
                        $target->setGameCharacter($character);
                        $target->setSkillHealEffect($effect);
                        $effect->addTarget($target);
                        $this->manager->persist($target);
                    }
                }
            }
        }

        //Status effects > for each, we parse characters and if one is targeted, we create new target
        foreach($action->getSkillStatusEffects() as $effect) {
            if(isset($postTargets["statusEffects"][$effect->getId()])) {
                foreach($activeCharacters as $character) {
                    if(isset($postTargets["statusEffects"][$effect->getId()][$character->getId()]) && $postTargets["statusEffects"][$effect->getId()][$character->getId()] === "true") {
                        $target = new Target();
                        $target->setGameCharacter($character);
                        $target->setSkillStatusEffect($effect);
                        $effect->addTarget($target);
                        $this->manager->persist($target);
                    }
                }
            }
        }

        //We flush get preview action view
        $this->manager->flush();
    }

    public function wipeTargets(Action $action)
    {
        foreach($action->getSkillDamageEffects() as $effect) {
            foreach($effect->getTargets() as $target) {
                $this->manager->remove($target);
                $effect->removeTarget($target);
            }
        }
        foreach($action->getSkillHealEffects() as $effect) {
            foreach($effect->getTargets() as $target) {
                $this->manager->remove($target);
                $effect->removeTarget($target);
            }
        }
        $this->manager->persist($action);
    }

}