<?php

namespace App\Entity;

use App\Repository\ConsumableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConsumableRepository::class)
 */
class Consumable extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="consumables")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Game $game;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\OneToMany(targetEntity=SkillHealEffect::class, mappedBy="consumable")
     */
    private ?Collection $skillHealEffects;

    /**
     * @ORM\OneToMany(targetEntity=SkillDamageEffect::class, mappedBy="consumable")
     */
    private ?Collection $skillDamageEffects;

    /**
     * @ORM\OneToMany(targetEntity=SkillStatusEffect::class, mappedBy="consumable")
     */
    private ?Collection $skillStatusEffects;

    public function __construct()
    {
        $this->skillHealEffects = new ArrayCollection();
        $this->skillDamageEffects = new ArrayCollection();
        $this->skillStatusEffects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $skillHealEffect->setConsumable($this);
        }

        return $this;
    }

    public function removeSkillHealEffect(SkillHealEffect $skillHealEffect): self
    {
        if ($this->skillHealEffects->contains($skillHealEffect)) {
            $this->skillHealEffects->removeElement($skillHealEffect);
            // set the owning side to null (unless already changed)
            if ($skillHealEffect->getConsumable() === $this) {
                $skillHealEffect->setConsumable(null);
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
            $skillDamageEffect->setConsumable($this);
        }

        return $this;
    }

    public function removeSkillDamageEffect(SkillDamageEffect $skillDamageEffect): self
    {
        if ($this->skillDamageEffects->contains($skillDamageEffect)) {
            $this->skillDamageEffects->removeElement($skillDamageEffect);
            // set the owning side to null (unless already changed)
            if ($skillDamageEffect->getConsumable() === $this) {
                $skillDamageEffect->setConsumable(null);
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
            $skillStatusEffect->setConsumable($this);
        }

        return $this;
    }

    public function removeSkillStatusEffect(SkillStatusEffect $skillStatusEffect): self
    {
        if ($this->skillStatusEffects->contains($skillStatusEffect)) {
            $this->skillStatusEffects->removeElement($skillStatusEffect);
            // set the owning side to null (unless already changed)
            if ($skillStatusEffect->getConsumable() === $this) {
                $skillStatusEffect->setConsumable(null);
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasEffect() :bool
    {
        $effects = count($this->getSkillHealEffects()) + count($this->getSkillDamageEffects()) + count($this->getSkillStatusEffects());
        if($effects > 0) {
            return true;
        }
        return false;
    }
}
