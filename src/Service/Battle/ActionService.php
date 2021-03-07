<?php

namespace App\Service\Battle;

use App\Entity\Action;
use App\Entity\BattleLog;
use App\Entity\CharacterResource;
use App\Entity\CharacterStatusEffect;
use App\Entity\Game;
use App\Entity\GameCharacter;
use App\Entity\PotencyAugmentator;
use App\Entity\SkillCost;
use App\Entity\SkillDamageEffect;
use App\Entity\SkillGain;
use App\Entity\SkillHealEffect;
use App\Entity\SkillStatusEffect;
use App\Service\CharacteristicsManager;
use App\Service\GameEnv;
use Doctrine\ORM\EntityManagerInterface;

class ActionService
{

    private Game $game;
    private EntityManagerInterface $manager;
    private CharacteristicsManager $characteristicsManager;
    private array $charactersToCheck = [];
    private array $appliedLogs = [];

    /**
     * @param GameEnv $gameEnv
     * @param EntityManagerInterface $manager
     * @param CharacteristicsManager $characteristicsManager
     */
    public function __construct(GameEnv $gameEnv, EntityManagerInterface $manager, CharacteristicsManager $characteristicsManager)
    {
        $this->game = $gameEnv->getGame();
        $this->characteristicsManager = $characteristicsManager;
        $this->manager = $manager;
    }

    public function getGame() :Game { return $this->game; }

    public function hydrateAction($relationEntity, $entity, Action $action)
    {
        //Hydrate name, type and children if action is not already hydrated
        $name = "Custom action";
        if(method_exists($entity, "getName"))
            $name = $entity->getName();
        $action->setName($name);
        $type = "custom";
        if(method_exists($entity, "getClassName"))
            $type = $entity->getClassName();
        $action->setType($type);

        //Hydrate children
        if(method_exists($entity, "getSkillHealEffects")) {
            foreach($entity->getSkillHealEffects() as $skillHealEffect) {
                $effect = new SkillHealEffect();
                $effect->setResource($skillHealEffect->getResource());
                $effect->setValue($skillHealEffect->getValue());
                $effect->setCalculationType($skillHealEffect->getCalculationType());
                $effect->setAction($action);
                foreach($skillHealEffect->getPotencyAugmentator() as $augmentator) {
                    $effect->addPotencyAugmentator($augmentator);
                }
                $this->manager->persist($effect);
                $action->addSkillHealEffect($effect);
            }
        }
        if(method_exists($entity, "getSkillDamageEffects")) {
            foreach($entity->getSkillDamageEffects() as $skillDamageEffect) {
                $effect = new SkillDamageEffect();
                $effect->setResource($skillDamageEffect->getResource());
                $effect->setValue($skillDamageEffect->getValue());
                $effect->setCalculationType($skillDamageEffect->getCalculationType());
                $effect->setIgnoreDefense($skillDamageEffect->getIgnoreDefense());
                $effect->setDamageNature($skillDamageEffect->getDamageNature());
                $effect->setAction($action);
                foreach($skillDamageEffect->getPotencyAugmentator() as $augmentator) {
                    $effect->addPotencyAugmentator($augmentator);
                }
                $this->manager->persist($effect);
                $action->addSkillDamageEffect($effect);
            }
        }
        if(method_exists($entity, "getSkillStatusEffects")) {
            foreach($entity->getSkillStatusEffects() as $skillStatusEffect) {
                $effect = new SkillStatusEffect();
                $effect->setStatusEffect($skillStatusEffect->getStatusEffect());
                $effect->setDuration($skillStatusEffect->getDuration());
                $effect->setAction($action);
                $this->manager->persist($effect);
                $action->addSkillStatusEffect($effect);
            }
        }
        if(method_exists($entity, "getSkillCosts")) {
            foreach($entity->getSkillCosts() as $skillCost) {
                $cost = new SkillCost();
                $cost->setResource($skillCost->getResource());
                $cost->setValue($skillCost->getValue());
                $cost->setCalculationType($skillCost->getCalculationType());
                $cost->setAction($action);
                $this->manager->persist($cost);
                $action->addSkillCost($cost);
            }
        }
        if(method_exists($entity, "getSkillGains")) {
            foreach($entity->getSkillGains() as $skillGain) {
                $gain = new SkillGain();
                $gain->setResource($skillGain->getResource());
                $gain->setValue($skillGain->getValue());
                $gain->setCalculationType($skillGain->getCalculationType());
                $this->manager->persist($gain);
                $action->addSkillGain($gain);
            }
        }
        $action->setIsHydrated(true);
        $action->setHasBeenTransformed(false);
        $action->setHasBeenLaunched(false);

        //Hydrate battle infos
        if(method_exists($relationEntity, "getGameCharacter")) {
            $action->setLauncher($relationEntity->getGameCharacter());
            $action->setTeam($relationEntity->getGameCharacter()->getTeam());
        }
        $action->setTurn($this->getGame()->getCurrentBattle()->getTurnsNumber());
        $action->setBattle($this->getGame()->getCurrentBattle());
        $this->getGame()->getCurrentBattle()->addAction($action);

        //Persist and flush
        $this->manager->persist($action);
        $this->manager->flush();
    }

    public function applyAction(Action $action)
    {
        //We wipe data setted
        $this->appliedLogs = [];
        $this->charactersToCheck = [];

        foreach($action->getBattleLogs() as $log) {

            //Handle resource diminution or augmentation
            switch($log->getType()) {

                case BattleLog::TYPE_COST:
                    $characterResource = $action->getLauncher()->seekCharacterResource($log->getTargetedResource());
                    $characterResource->setCurrentValue($characterResource->getCurrentValue() - $log->getFinalValue());
                    $this->charactersToCheck[$action->getLauncher()->getId()] = $action->getLauncher();
                    $this->appliedLogs[] = $log;
                    break;

                case BattleLog::TYPE_GAIN:
                    $characterResource = $action->getLauncher()->seekCharacterResource($log->getTargetedResource());
                    $characterResource->setCurrentValue($characterResource->getCurrentValue() + $log->getFinalValue());
                    $this->charactersToCheck[$action->getLauncher()->getId()] = $action->getLauncher();
                    $this->appliedLogs[] = $log;
                    break;

                case BattleLog::TYPE_DAMAGE:
                    $characterResource = $log->getTarget()->seekCharacterResource($log->getTargetedResource());
                    $characterResource->setCurrentValue($characterResource->getCurrentValue() - $log->getFinalValue());
                    $this->charactersToCheck[$log->getTarget()->getId()] = $log->getTarget();
                    $this->appliedLogs[] = $log;
                    break;

                case BattleLog::TYPE_HEAL:
                    $characterResource = $log->getTarget()->seekCharacterResource($log->getTargetedResource());
                    $characterResource->setCurrentValue($characterResource->getCurrentValue() + $log->getFinalValue());
                    $this->charactersToCheck[$log->getTarget()->getId()] = $log->getTarget();
                    $this->appliedLogs[] = $log;
                    break;

                case BattleLog::TYPE_STATUS_EFFECT:
                    $characterStatusEffect = new CharacterStatusEffect();
                    $characterStatusEffect->setGameCharacter($log->getTarget());
                    $characterStatusEffect->setStatusEffect($log->getStatusEffect());
                    $characterStatusEffect->setRemainingTurns($log->getStatusEffectTurns());
                    $characterStatusEffect->setWipeIfReset(true);
                    $this->manager->persist($characterStatusEffect);
                    $log->getTarget()->addCharacterStatusEffect($characterStatusEffect);
                    $this->charactersToCheck[$log->getTarget()->getId()] = $log->getTarget();
                    break;

            }

        }

    }

    public function checkAndFlush()
    {

        /** @var GameCharacter $gameCharacter */
        foreach($this->charactersToCheck as $gameCharacter) {
            $this->characteristicsManager->calculateCharacteristics($gameCharacter);
        }

        //Handle logs update
        /** @var BattleLog $log */
        foreach($this->appliedLogs as $log) {
            $log->setIsApplied(true);
            $this->manager->persist($log);
        }

        //Flush
        $this->manager->flush();

    }

}