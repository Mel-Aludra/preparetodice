<?php

namespace App\Entity;

use App\Repository\SkillHealEffectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillHealEffectRepository::class)
 */
class SkillHealEffect extends Entity
{

    public function __toString()
    {
        $value = $this->getValue();
        switch($this->getCalculationType()) {
            case "percent_max":
                $value = $value . "% (max value)";
                break;
            case "percent_current":
                $value = $value . "% (current value)";
                break;
        }
        return $value . " " . $this->getResource()->getAbreviation();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="skillHealEffects")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Skill $skill;

    /**
     * @ORM\ManyToOne(targetEntity=Resource::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Resource $resource;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $calculationType;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $value;

    /**
     * @ORM\ManyToOne(targetEntity=Weapon::class, inversedBy="skillHealEffects")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Weapon $weapon;

    /**
     * @ORM\ManyToOne(targetEntity=Consumable::class, inversedBy="skillHealEffects")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Consumable $consumable;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="skillHealEffects")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Action $action;

    /**
     * @ORM\OneToMany(targetEntity=Target::class, mappedBy="skillHealEffect")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Collection $targets;

    /**
     * @ORM\ManyToMany(targetEntity=PotencyAugmentator::class, inversedBy="skillHealEffects")
     */
    private $potencyAugmentator;

    public function __construct()
    {
        $this->targets = new ArrayCollection();
        $this->potencyAugmentator = new ArrayCollection();
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

    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    public function setResource(?Resource $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    public function getCalculationType(): ?string
    {
        return $this->calculationType;
    }

    public function setCalculationType(string $calculationType): self
    {
        $this->calculationType = $calculationType;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

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
            $target->setSkillHealEffect($this);
        }

        return $this;
    }

    public function removeTarget(Target $target): self
    {
        if ($this->targets->contains($target)) {
            $this->targets->removeElement($target);
            // set the owning side to null (unless already changed)
            if ($target->getSkillHealEffect() === $this) {
                $target->setSkillHealEffect(null);
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

    /**
     * @return Collection|PotencyAugmentator[]
     */
    public function getPotencyAugmentator(): Collection
    {
        return $this->potencyAugmentator;
    }

    public function addPotencyAugmentator(PotencyAugmentator $potencyAugmentator): self
    {
        if (!$this->potencyAugmentator->contains($potencyAugmentator)) {
            $this->potencyAugmentator[] = $potencyAugmentator;
        }

        return $this;
    }

    public function removePotencyAugmentator(PotencyAugmentator $potencyAugmentator): self
    {
        if ($this->potencyAugmentator->contains($potencyAugmentator)) {
            $this->potencyAugmentator->removeElement($potencyAugmentator);
        }

        return $this;
    }
}
