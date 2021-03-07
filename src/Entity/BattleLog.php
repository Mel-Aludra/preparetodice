<?php

namespace App\Entity;

use App\Repository\BattleLogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BattleLogRepository::class)
 */
class BattleLog extends Entity
{

    const TYPE_DAMAGE = "damage";
    const TYPE_HEAL = "heal";
    const TYPE_STATUS_EFFECT = "status";
    const TYPE_COST = "cost";
    const TYPE_GAIN = "gain";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Battle::class, inversedBy="battleLogs")
     */
    private ?Battle $battle;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="battleLogs")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private ?Action $action;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $type;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $turn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\ManyToOne(targetEntity=GameCharacter::class)
     */
    private ?GameCharacter $launcher;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $launcherTeam;

    /**
     * @ORM\ManyToOne(targetEntity=gameCharacter::class)
     */
    private ?GameCharacter $target;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $targetTeam;

    /**
     * @ORM\ManyToOne(targetEntity=Resource::class)
     */
    private ?Resource $targetedResource;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $initialValue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $additionalPotencyValue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $rollPotencyResult;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $rollActionResult;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $defenseValue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $rationalizeValue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $finalValue;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isApplied;

    /**
     * @ORM\ManyToOne(targetEntity=StatusEffect::class)
     */
    private ?StatusEffect $statusEffect;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $statusEffectTurns;

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

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(?Action $action): self
    {
        $this->action = $action;

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

    public function getTurn(): ?int
    {
        return $this->turn;
    }

    public function setTurn(int $turn): self
    {
        $this->turn = $turn;

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

    public function getLauncher(): ?GameCharacter
    {
        return $this->launcher;
    }

    public function setLauncher(?GameCharacter $launcher): self
    {
        $this->launcher = $launcher;

        return $this;
    }

    public function getLauncherTeam(): ?string
    {
        return $this->launcherTeam;
    }

    public function setLauncherTeam(string $launcherTeam): self
    {
        $this->launcherTeam = $launcherTeam;

        return $this;
    }

    public function getTarget(): ?gameCharacter
    {
        return $this->target;
    }

    public function setTarget(?gameCharacter $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getTargetTeam(): ?string
    {
        return $this->targetTeam;
    }

    public function setTargetTeam(string $targetTeam): self
    {
        $this->targetTeam = $targetTeam;

        return $this;
    }

    public function getTargetedResource(): ?Resource
    {
        return $this->targetedResource;
    }

    public function setTargetedResource(?Resource $targetedResource): self
    {
        $this->targetedResource = $targetedResource;

        return $this;
    }

    public function getInitialValue(): ?int
    {
        return $this->initialValue;
    }

    public function setInitialValue(?int $initialValue): self
    {
        $this->initialValue = $initialValue;

        return $this;
    }

    public function getAdditionalPotencyValue(): ?int
    {
        return $this->additionalPotencyValue;
    }

    public function setAdditionalPotencyValue(?int $additionalPotencyValue): self
    {
        $this->additionalPotencyValue = $additionalPotencyValue;

        return $this;
    }

    public function getRollPotencyResult(): ?int
    {
        return $this->rollPotencyResult;
    }

    public function setRollPotencyResult(?int $rollPotencyResult): self
    {
        $this->rollPotencyResult = $rollPotencyResult;

        return $this;
    }

    public function getRollActionResult(): ?int
    {
        return $this->rollActionResult;
    }

    public function setRollActionResult(?int $rollActionResult): self
    {
        $this->rollActionResult = $rollActionResult;

        return $this;
    }

    public function getDefenseValue(): ?int
    {
        return $this->defenseValue;
    }

    public function setDefenseValue(?int $defenseValue): self
    {
        $this->defenseValue = $defenseValue;

        return $this;
    }

    public function getRationalizeValue(): ?int
    {
        return $this->rationalizeValue;
    }

    public function setRationalizeValue(?int $rationalizeValue): self
    {
        $this->rationalizeValue = $rationalizeValue;

        return $this;
    }

    public function getFinalValue(): ?int
    {
        return $this->finalValue;
    }

    public function setFinalValue(?int $finalValue): self
    {
        $this->finalValue = $finalValue;

        return $this;
    }

    public function getIsApplied(): ?bool
    {
        return $this->isApplied;
    }

    public function setIsApplied(bool $isApplied): self
    {
        $this->isApplied = $isApplied;

        return $this;
    }

    public function getStatusEffect(): ?StatusEffect
    {
        return $this->statusEffect;
    }

    public function setStatusEffect(?StatusEffect $statusEffect): self
    {
        $this->statusEffect = $statusEffect;

        return $this;
    }

    public function getStatusEffectTurns(): ?int
    {
        return $this->statusEffectTurns;
    }

    public function setStatusEffectTurns(?int $statusEffectTurns): self
    {
        $this->statusEffectTurns = $statusEffectTurns;

        return $this;
    }

    public function getSigle()
    {
        if($this->getType() === self::TYPE_DAMAGE) {
            return "-";
        }
        else if($this->getType() === self::TYPE_HEAL) {
            return "+";
        }
        return "";
    }

    public function getIconName()
    {
        switch($this->getType()) {
            case self::TYPE_DAMAGE:
                return "fal fa-claw-marks"; break;
            case self::TYPE_HEAL:
                return "fal fa-prescription-bottle-alt"; break;
            case self::TYPE_STATUS_EFFECT:
                return "fal fa-viruses"; break;
            case self::TYPE_COST:
                return "fal fa-user-minus"; break;
            case self::TYPE_GAIN:
                return "fal fa-user-plus"; break;
        }
        return "";
    }

}
