<?php

namespace App\Service\Battle;


use App\Entity\Battle;
use App\Entity\BattleLog;
use App\Entity\DamageOverTime;
use App\Entity\GameCharacter;
use App\Entity\HealOverTime;
use App\Repository\GameCharacterRepository;
use App\Service\CharacteristicsManager;
use App\Service\GameEnv;
use Doctrine\ORM\EntityManagerInterface;

class StatusEffectApplierService
{

    private CharacteristicsManager $characteristicsManager;
    private EntityManagerInterface $manager;
    private GameEnv $gameEnv;
    private GameCharacterRepository $charactersRepo;

    public function __construct(CharacteristicsManager $characteristicsManager, EntityManagerInterface $manager, GameEnv $gameEnv, GameCharacterRepository $characterRepo)
    {
        $this->characteristicsManager = $characteristicsManager;
        $this->manager = $manager;
        $this->gameEnv = $gameEnv;
        $this->charactersRepo = $characterRepo;
    }

    /**
     */
    public function finishTurnStatusEffectsApplier()
    {

        //Characters who need to recalculate stats
        $charactersToCheck = [];
        $logs = [];
        $battle = $this->gameEnv->getGame()->getCurrentBattle();

        //Get teams
        $allies = $this->charactersRepo->findBy(["game" => $this->gameEnv->getGame()->getId(), "team" => "allies"]);
        $foes = $this->charactersRepo->findBy(["game" => $this->gameEnv->getGame()->getId(), "team" => "foes"]);
        $characters = [];
        foreach($allies as $ally)
            $characters[] = $ally;
        foreach($foes as $foe)
            $characters[] = $foe;

        /** @var GameCharacter $gameCharacter */
        foreach($characters as $gameCharacter) {

            //For each character, we restore all action points
            if($this->gameEnv->getGame()->getActionPointsResource() != null) {
                $actionPoints = $gameCharacter->seekCharacterResource($this->gameEnv->getGame()->getActionPointsResource());
                $actionPoints->setCurrentValue($actionPoints->getFinalValue());
                $this->manager->persist($actionPoints);
            }

            $passivesDots = [];
            $passivesHots = [];
            $statusEffectsDots = [];
            $statusEffectsHots = [];

            //We get all damage and heal over time
            foreach($gameCharacter->getCharacterPassives() as $characterPassive) {
                foreach($characterPassive->getPassive()->getDamageOverTimes() as $dot)
                    $passivesDots[] = $dot;
                foreach($characterPassive->getPassive()->getHealOverTimes() as $hot)
                    $passivesHots[] = $hot;
            }
            foreach($gameCharacter->getCharacterStatusEffects() as $characterStatusEffect) {
                foreach($characterStatusEffect->getStatusEffect()->getDamageOverTimes() as $dot)
                    $statusEffectsDots[] = $dot;
                foreach($characterStatusEffect->getStatusEffect()->getHealOverTimes() as $hot)
                    $statusEffectsHots[] = $hot;
            }

            //Passives dot applier
            foreach($passivesDots as $passiveDot) {
                $log = $this->dotToLog($passiveDot, $gameCharacter);
                $log->setName("Passive " . $passiveDot->getPassive()->getName() . " (dot)");
                $log->setTarget($gameCharacter);
                $log->setLauncherTeam($gameCharacter->getTeam());
                $log->setTargetTeam($gameCharacter->getTeam());
                $logs[] = $log;
            }

            //Passives hot applier
            foreach($passivesHots as $passiveHot) {
                $log = $this->hotToLog($passiveHot, $gameCharacter);
                $log->setName("Passive " . $passiveHot->getPassive()->getName() . " (hot)");
                $log->setTarget($gameCharacter);
                $log->setLauncherTeam($gameCharacter->getTeam());
                $log->setTargetTeam($gameCharacter->getTeam());
                $logs[] = $log;
            }

            //Status effects dot applier (LAUNCHER TEAM IS AN ERROR, WE DON'T HAVE INFO TO KNOW WHO IS THE LAUNCHER)
            foreach($statusEffectsDots as $statusEffectDot) {
                $log = $this->dotToLog($statusEffectDot, $gameCharacter);
                $log->setName("Status effect " . $statusEffectDot->getStatusEffect()->getName() . " (dot)");
                $log->setTarget($gameCharacter);
                $log->setTargetTeam($gameCharacter->getTeam());
                if($gameCharacter->getTeam() === GameCharacter::TEAM_ALLIES)
                    $log->setLauncherTeam(GameCharacter::TEAM_FOES);
                else
                    $log->setLauncherTeam(GameCharacter::TEAM_ALLIES);
                $logs[] = $log;
            }

            //Status effects hot applier
            foreach($statusEffectsHots as $statusEffectHot) {
                $log = $this->hotToLog($statusEffectHot, $gameCharacter);
                $log->setName("Status effect " . $statusEffectHot->getStatusEffect()->getName() . " (hot)");
                $log->setTarget($gameCharacter);
                $log->setTargetTeam($gameCharacter->getTeam());
                $log->setLauncherTeam($gameCharacter->getTeam());
                $logs[] = $log;
            }

        }

        //We parse logs and apply it
        /** @var BattleLog $log */
        foreach($logs as $log) {

            //Battle infos
            $log->setBattle($battle);
            $battle->addBattleLog($log);
            $log->setTurn($battle->getTurnsNumber());

            //Manager character resource increase or decrease
            $characterResource = $log->getTarget()->seekCharacterResource($log->getTargetedResource());
            if($characterResource !== null) {
                switch($log->getType()) {
                    case BattleLog::TYPE_DAMAGE:
                        $characterResource->setCurrentValue($characterResource->getCurrentValue() - $log->getFinalValue());
                        break;
                    case BattleLog::TYPE_HEAL:
                        $characterResource->setCurrentValue($characterResource->getCurrentValue() + $log->getFinalValue());
                        break;
                }
                $charactersToCheck[$log->getTarget()->getId()] = $log->getTarget();
            }

            //Apply log and persist
            $log->setIsApplied(true);
            $this->manager->persist($log);

        }


        //Each limited in turns status effect decreases by 1
        foreach($characters as $gameCharacter) {
            foreach($gameCharacter->getCharacterStatusEffects() as $characterStatusEffect) {
                if($characterStatusEffect->getRemainingTurns() != null) {
                    $characterStatusEffect->setRemainingTurns($characterStatusEffect->getRemainingTurns() - 1);
                    $this->manager->persist($characterStatusEffect);
                    if($characterStatusEffect->getRemainingTurns() <= 0) {
                        $this->manager->remove($characterStatusEffect);
                    }
                }
            }
        }
        $this->manager->flush();

        //For each character touch, we calculate stats and flush all
        foreach($charactersToCheck as $gameCharacter) {
            $this->characteristicsManager->calculateCharacteristics($gameCharacter);
        }



    }

    /**
     * @param DamageOverTime $damageOverTime
     * @param GameCharacter $target
     * @return BattleLog
     */
    private function dotToLog(DamageOverTime $damageOverTime, GameCharacter $target) :BattleLog
    {

        $log = new BattleLog();
        $value = 0;
        $characterResource = $target->seekCharacterResource($damageOverTime->getResource());

        //PROPERTIES
        $log->setType(BattleLog::TYPE_DAMAGE);
        $log->setTargetedResource($damageOverTime->getResource());

        //VALUE
        if($characterResource !== null) {
            //Value depends on calculation type
            switch($damageOverTime->getCalculationType()) {
                case "points":
                    $value = $damageOverTime->getValue();
                    break;
                case "percent_max":
                    $value = round($damageOverTime->getValue() * $characterResource->getFinalValue() / 100);
                    break;
                case "percent_current":
                    $value = round($damageOverTime->getValue() * $characterResource->getCurrentValue() / 100);
                    break;
            }
        }
        $log->setInitialValue($value);

        //DEFENSE
        if($damageOverTime->getIgnoreDefense() !== true)
            $log->setDefenseValue($log->getInitialValue() * $target->getDamageNatureDefense($damageOverTime->getDamageNature()) / 100);
        else
            $log->setDefenseValue(0);

        //FINAL VALUE
        $log->setFinalValue($log->getInitialValue() - $log->getDefenseValue());

        //RETURN
        return $log;

    }

    /**
     * @param HealOverTime $healOverTime
     * @param GameCharacter $target
     * @return BattleLog
     */
    private function hotToLog(HealOverTime $healOverTime, GameCharacter $target) :BattleLog
    {

        $log = new BattleLog();
        $value = 0;
        $characterResource = $target->seekCharacterResource($healOverTime->getResource());

        //PROPERTIES
        $log->setType(BattleLog::TYPE_HEAL);
        $log->setTargetedResource($healOverTime->getResource());

        //VALUE
        if($characterResource !== null) {
            //Value depends on calculation type
            switch($healOverTime->getCalculationType()) {
                case "points":
                    $value = $healOverTime->getValue();
                    break;
                case "percent_max":
                    $value = round($healOverTime->getValue() * $characterResource->getFinalValue() / 100);
                    break;
                case "percent_current":
                    $value = round($healOverTime->getValue() * $characterResource->getCurrentValue() / 100);
                    break;
            }
        }
        $log->setDefenseValue(null);
        $log->setInitialValue($value);
        $log->setFinalValue($value);

        //RETURN
        return $log;

    }

}