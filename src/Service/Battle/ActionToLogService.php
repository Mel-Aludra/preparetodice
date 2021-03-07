<?php

namespace App\Service\Battle;

use App\Entity\Action;
use App\Entity\BattleLog;
use App\Entity\Game;
use App\Entity\GameCharacter;
use App\Entity\SkillCost;
use App\Entity\SkillStatusEffect;
use App\Service\GameEnv;
use Doctrine\ORM\EntityManagerInterface;

class ActionToLogService
{

    private Game $game;
    private PotencyAugmentatorService $potencyAugmentatorService;
    private EntityManagerInterface $manager;

    /**
     * @param GameEnv $gameEnv
     * @param EntityManagerInterface $manager
     */
    public function __construct(GameEnv $gameEnv, EntityManagerInterface $manager, PotencyAugmentatorService $potencyAugmentatorService)
    {
        $this->game = $gameEnv->getGame();
        $this->potencyAugmentatorService = $potencyAugmentatorService;
        $this->manager = $manager;
    }

    public function getGame() :Game { return $this->game; }

    /**
     * Give action and get all logs from this action
     * @param Action $action
     */
    public function actionToLogs(Action $action)
    {
        //If action is already hydrated, we don't do anything
        if($action->getHasBeenTransformed()) {
            return;
        }

        //We create logs from action entity
        $logs = [];
        foreach($action->getSkillDamageEffects() as $effect) {
            foreach($effect->getTargets() as $target) {
                $logs[] = $this->damageOrHealEffectToLog($effect, $target->getGameCharacter());
            }
        }
        foreach($action->getSkillHealEffects() as $effect) {
            foreach($effect->getTargets() as $target) {
                $logs[] = $this->damageOrHealEffectToLog($effect, $target->getGameCharacter());
            }
        }
        foreach($action->getSkillStatusEffects() as $effect) {
            foreach($effect->getTargets() as $target) {
                $logs[] = $this->statusEffectEffectToLog($effect, $target->getGameCharacter());
            }
        }
        foreach($action->getSkillCosts() as $costOrGain) {
            $logs[] = $this->skillCostOrGainToLog($costOrGain, $action->getLauncher());
        }
        foreach($action->getSkillGains() as $costOrGain) {
            $logs[] = $this->skillCostOrGainToLog($costOrGain, $action->getLauncher());
        }

        //We set logs to action
        foreach($logs as $log) {
            $log->setBattle($this->getGame()->getCurrentBattle()); $this->getGame()->getCurrentBattle()->addBattleLog($log);
            $log->setAction($action); $action->addBattleLog($log);
            $this->manager->persist($log);
        }
        $action->setHasBeenTransformed(true);
        $this->manager->persist($action);
    }

    #region subFunctions

    /**
     * @param $actionChildEntity
     * @param GameCharacter $target
     * @return BattleLog
     */
    private function damageOrHealEffectToLog($actionChildEntity, GameCharacter $target)
    {
        $log = $this->createLogFromAction($actionChildEntity, $target);
        $log->setInitialValue($actionChildEntity->getValue());
        $log->setAdditionalPotencyValue($this->potencyAugmentatorService->extractPotencyAugmentatorsValueFromEffect($actionChildEntity,$actionChildEntity->getAction()->getLauncher()));
        if($actionChildEntity->getClassName() === "skillDamageEffect") {
            $defense = 0;
            if($actionChildEntity->getIgnoreDefense() !== true) {
                $percentBlocked = $target->getDamageNatureDefense($actionChildEntity->getDamageNature());
                $defense = (($log->getInitialValue() + $log->getAdditionalPotencyValue()) * $percentBlocked / 100);
            }
            $log->setDefenseValue($defense);
        } else {
            $log->setDefenseValue(null);
        }
        $log->setTargetedResource($actionChildEntity->getResource());
        $log->setFinalValue($log->getInitialValue() + (int) $log->getAdditionalPotencyValue() - $log->getDefenseValue());
        return $log;
    }

    /**
     * @param SkillStatusEffect $skillStatusEffect
     * @param GameCharacter $target
     * @return BattleLog
     */
    private function statusEffectEffectToLog(SkillStatusEffect $skillStatusEffect, GameCharacter $target)
    {
        $log = $this->createLogFromAction($skillStatusEffect, $target);
        $log->setStatusEffect($skillStatusEffect->getStatusEffect());
        $log->setStatusEffectTurns($skillStatusEffect->getDuration());
        return $log;
    }

    /**
     * @param $skillCostOrGain
     * @param GameCharacter $launcher
     * @return BattleLog
     */
    private function skillCostOrGainToLog($skillCostOrGain, GameCharacter $launcher)
    {
        $log = $this->createLogFromAction($skillCostOrGain, $launcher);
        $log->setInitialValue($skillCostOrGain->getValue());
        $log->setRationalizeValue(0);
        $log->setTargetedResource($skillCostOrGain->getResource());
        $log->setFinalValue($log->getInitialValue());
        return $log;
    }

    /**
     * @param $actionChildEntity
     * @param GameCharacter $character
     * @return BattleLog
     */
    private function createLogFromAction($actionChildEntity, GameCharacter $character)
    {
        $log = new BattleLog();
        $action = $actionChildEntity->getAction();
        switch($actionChildEntity->getClassName()) {
            case "skillDamageEffect": $log->setType(BattleLog::TYPE_DAMAGE); break;
            case "skillHealEffect": $log->setType(BattleLog::TYPE_HEAL); break;
            case "skillStatusEffect": $log->setType(BattleLog::TYPE_STATUS_EFFECT); break;
            case "skillCost": $log->setType(BattleLog::TYPE_COST); break;
            case "skillGain": $log->setType(BattleLog::TYPE_GAIN); break;
        }
        $log->setBattle($action->getBattle());
        $log->setAction($action);
        $log->setName($action->getName());
        $log->setTarget($character);
        $log->setLauncher($action->getLauncher());
        $log->setTargetTeam($character->getTeam());
        $log->setLauncherTeam($action->getLauncher()->getTeam());
        $log->setTurn($action->getBattle()->getTurnsNumber());
        $log->setIsApplied(false);
        return $log;
    }

    #endregion

}