<?php

namespace App\Entity;

use App\Repository\SkillStatusEffectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillStatusEffectRepository::class)
 */
class SkillStatusEffect extends Entity
{
    public function __toString()
    {
        return $this->getStatusEffect()->getName() . " (" . $this->getDuration() . " turns)";
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="skillStatusEffects")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Skill $skill;

    /**
     * @ORM\ManyToOne(targetEntity=StatusEffect::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?StatusEffect $statusEffect;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $duration;

    /**
     * @ORM\ManyToOne(targetEntity=Weapon::class, inversedBy="skillStatusEffects")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Weapon $weapon;

    /**
     * @ORM\ManyToOne(targetEntity=Consumable::class, inversedBy="skillStatusEffects")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Consumable $consumable;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="skillStatusEffects")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Action $action;

    /**
     * @ORM\OneToMany(targetEntity=Target::class, mappedBy="skillStatusEffect")
     */
    private ?Collection $targets;

    public function __construct()
    {
        $this->targets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    public function setWeapon(?Weapon $weapon): self
    {
        $this->weapon = $weapon;

        return $this;
    }

    public function getConsumable(): ?Consumable
    {
        return $this->consumable;
    }

    public function setConsumable(?Consumable $consumable): self
    {
        $this->consumable = $consumable;

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

    /**
     * @return Collection|Target[]
     */
    public function getTargets(): Collection
    {
        return $this->targets;
    }

    public function addTarget(Target $target): self
    {
        if (!$this->targets->contains($target)) {
            $this->targets[] = $target;
            $target->setSkillStatusEffect($this);
        }

        return $this;
    }

    public function removeTarget(Target $target): self
    {
        if ($this->targets->contains($target)) {
            $this->targets->removeElement($target);
            // set the owning side to null (unless already changed)
            if ($target->getSkillStatusEffect() === $this) {
                $target->setSkillStatusEffect(null);
            }
        }

        return $this;
    }

    /**
     * @param GameCharacter $character
     * @return bool
     */
    public function isTargetingCharacter(GameCharacter $character) :bool
    {
        foreach($this->getTargets() as $target) {
            if($target->getGameCharacter()->getId() === $character->getId())
                return true;
        }
        return false;
    }
}
