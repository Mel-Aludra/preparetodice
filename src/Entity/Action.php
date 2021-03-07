<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActionRepository::class)
 */
class Action extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Battle::class, inversedBy="actions")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Battle $battle;

    /**
     * @ORM\ManyToOne(targetEntity=gameCharacter::class, inversedBy="actions")
     */
    private ?GameCharacter $launcher;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $team;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $turn;

    /**
     * @ORM\OneToMany(targetEntity=SkillHealEffect::class, mappedBy="action", orphanRemoval=true)
     */
    private ?Collection $skillHealEffects;

    /**
     * @ORM\OneToMany(targetEntity=SkillDamageEffect::class, mappedBy="action", orphanRemoval=true)
     */
    private ?Collection $skillDamageEffects;

    /**
     * @ORM\OneToMany(targetEntity=SkillCost::class, mappedBy="action")
     */
    private ?Collection $skillCosts;

    /**
     * @ORM\OneToMany(targetEntity=SkillGain::class, mappedBy="action")
     */
    private ?Collection $skillGains;

    /**
     * @ORM\OneToMany(targetEntity=BattleLog::class, mappedBy="action")
     */
    private ?Collection $battleLogs;

    /**
     * @ORM\OneToMany(targetEntity=SkillStatusEffect::class, mappedBy="action", orphanRemoval=true)
     */
    private ?Collection $skillStatusEffects;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isHydrated;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasBeenTransformed;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasBeenLaunched;

    public function __construct()
    {
        $this->skillHealEffects = new ArrayCollection();
        $this->skillDamageEffects = new ArrayCollection();
        $this->skillCosts = new ArrayCollection();
        $this->skillGains = new ArrayCollection();
        $this->battleLogs = new ArrayCollection();
        $this->skillStatusEffects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBattle(): ?Battle
    {
        return $this->battle;
    }

    public function setBattle(?Battle $battle): self
    {
        $this->battle = $battle;

        return $this;
    }

    public function getLauncher(): ?gameCharacter
    {
        return $this->launcher;
    }

    public function setLauncher(?gameCharacter $launcher): self
    {
        $this->launcher = $launcher;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTeam(): ?string
    {
        return $this->team;
    }

    public function setTeam(string $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getTurn(): ?int
    {
        return $this->turn;
    }

    public function setTurn(int $turn): self
    {
        $this->turn = $turn;

        return $this;
    }

    /**
     * @return Collection|SkillHealEffect[]
     */
    public function getSkillHealEffects(): Collection
    {
        return $this->skillHealEffects;
    }

    public function addSkillHealEffect(SkillHealEffect $skillHealEffect): self
    {
        if (!$this->skillHealEffects->contains($skillHealEffect)) {
            $this->skillHealEffects[] = $skillHealEffect;
            $skillHealEffect->setAction($this);
        }

        return $this;
    }

    public function removeSkillHealEffect(SkillHealEffect $skillHealEffect): self
    {
        if ($this->skillHealEffects->contains($skillHealEffect)) {
            $this->skillHealEffects->removeElement($skillHealEffect);
            // set the owning side to null (unless already changed)
            if ($skillHealEffect->getAction() === $this) {
                $skillHealEffect->setAction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SkillDamageEffect[]
     */
    public function getSkillDamageEffects(): Collection
    {
        return $this->skillDamageEffects;
    }

    public function addSkillDamageEffect(SkillDamageEffect $skillDamageEffect): self
    {
        if (!$this->skillDamageEffects->contains($skillDamageEffect)) {
            $this->skillDamageEffects[] = $skillDamageEffect;
            $skillDamageEffect->setAction($this);
        }

        return $this;
    }

    public function removeSkillDamageEffect(SkillDamageEffect $skillDamageEffect): self
    {
        if ($this->skillDamageEffects->contains($skillDamageEffect)) {
            $this->skillDamageEffects->removeElement($skillDamageEffect);
            // set the owning side to null (unless already changed)
            if ($skillDamageEffect->getAction() === $this) {
                $skillDamageEffect->setAction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SkillCost[]
     */
    public function getSkillCosts(): Collection
    {
        return $this->skillCosts;
    }

    public function addSkillCost(SkillCost $skillCost): self
    {
        if (!$this->skillCosts->contains($skillCost)) {
            $this->skillCosts[] = $skillCost;
            $skillCost->setAction($this);
        }

        return $this;
    }

    public function removeSkillCost(SkillCost $skillCost): self
    {
        if ($this->skillCosts->contains($skillCost)) {
            $this->skillCosts->removeElement($skillCost);
            // set the owning side to null (unless already changed)
            if ($skillCost->getAction() === $this) {
                $skillCost->setAction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SkillGain[]
     */
    public function getSkillGains(): Collection
    {
        return $this->skillGains;
    }

    public function addSkillGain(SkillGain $skillGain): self
    {
        if (!$this->skillGains->contains($skillGain)) {
            $this->skillGains[] = $skillGain;
            $skillGain->setAction($this);
        }

        return $this;
    }

    public function removeSkillGain(SkillGain $skillGain): self
    {
        if ($this->skillGains->contains($skillGain)) {
            $this->skillGains->removeElement($skillGain);
            // set the owning side to null (unless already changed)
            if ($skillGain->getAction() === $this) {
                $skillGain->setAction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BattleLog[]
     */
    public function getBattleLogs(): Collection
    {
        return $this->battleLogs;
    }

    public function addBattleLog(BattleLog $battleLog): self
    {
        if (!$this->battleLogs->contains($battleLog)) {
            $this->battleLogs[] = $battleLog;
            $battleLog->setAction($this);
        }

        return $this;
    }

    public function removeBattleLog(BattleLog $battleLog): self
    {
        if ($this->battleLogs->contains($battleLog)) {
            $this->battleLogs->removeElement($battleLog);
            // set the owning side to null (unless already changed)
            if ($battleLog->getAction() === $this) {
                $battleLog->setAction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SkillStatusEffect[]
     */
    public function getSkillStatusEffects(): Collection
    {
        return $this->skillStatusEffects;
    }

    public function addSkillStatusEffect(SkillStatusEffect $skillStatusEffect): self
    {
        if (!$this->skillStatusEffects->contains($skillStatusEffect)) {
            $this->skillStatusEffects[] = $skillStatusEffect;
            $skillStatusEffect->setAction($this);
        }

        return $this;
    }

    public function removeSkillStatusEffect(SkillStatusEffect $skillStatusEffect): self
    {
        if ($this->skillStatusEffects->contains($skillStatusEffect)) {
            $this->skillStatusEffects->removeElement($skillStatusEffect);
            // set the owning side to null (unless already changed)
            if ($skillStatusEffect->getAction() === $this) {
                $skillStatusEffect->setAction(null);
            }
        }

        return $this;
    }

    public function getIsHydrated(): ?bool
    {
        return $this->isHydrated;
    }

    public function setIsHydrated(bool $isHydrated): self
    {
        $this->isHydrated = $isHydrated;

        return $this;
    }

    public function getSortedLogs()
    {
        $logs = [
            BattleLog::TYPE_DAMAGE => [],
            BattleLog::TYPE_HEAL => [],
            BattleLog::TYPE_STATUS_EFFECT => [],
            BattleLog::TYPE_COST => [],
            BattleLog::TYPE_GAIN => []
        ];

        foreach($this->getBattleLogs() as $log) {

            //Damage
            if($log->getType() === BattleLog::TYPE_DAMAGE) {
                $logs[BattleLog::TYPE_DAMAGE][] = $log;
            }

            //Heal
            else if($log->getType() === BattleLog::TYPE_HEAL) {
                $logs[BattleLog::TYPE_HEAL][] = $log;
            }

            //Status
            else if($log->getType() === BattleLog::TYPE_STATUS_EFFECT) {
                $logs[BattleLog::TYPE_STATUS_EFFECT][] = $log;
            }

            //Costs
            else if($log->getType() === BattleLog::TYPE_COST) {
                $logs[BattleLog::TYPE_COST][] = $log;
            }

            //Gains
            else if($log->getType() === BattleLog::TYPE_GAIN) {
                $logs[BattleLog::TYPE_GAIN][] = $log;
            }
        }

        //Return
        return $logs;
    }

    public function haveAppliedLogs()
    {
        foreach($this->getBattleLogs() as $log) {
            if($log->getIsApplied())
                return true;
        }
        return false;
    }

    public function getHasBeenTransformed(): ?bool
    {
        return $this->hasBeenTransformed;
    }

    public function setHasBeenTransformed(bool $hasBeenTransformed): self
    {
        $this->hasBeenTransformed = $hasBeenTransformed;

        return $this;
    }

    public function getHasBeenLaunched(): ?bool
    {
        return $this->hasBeenLaunched;
    }

    public function setHasBeenLaunched(bool $hasBeenLaunched): self
    {
        $this->hasBeenLaunched = $hasBeenLaunched;

        return $this;
    }

}
