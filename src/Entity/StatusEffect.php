<?php

namespace App\Entity;

use App\Repository\StatusEffectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusEffectRepository::class)
 */
class StatusEffect extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="statusEffects")
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
     * @ORM\OneToMany(targetEntity=AttributeAlteration::class, mappedBy="statusEffect")
     */
    private ?Collection $attributeAlterations;

    /**
     * @ORM\OneToMany(targetEntity=ResourceAlteration::class, mappedBy="statusEffect")
     */
    private ?Collection $resourceAlterations;

    /**
     * @ORM\OneToMany(targetEntity=DamageOverTime::class, mappedBy="statusEffect")
     */
    private ?Collection $damageOverTimes;

    /**
     * @ORM\OneToMany(targetEntity=HealOverTime::class, mappedBy="statusEffect")
     */
    private ?Collection $healOverTimes;

    public function __construct()
    {
        $this->attributeAlterations = new ArrayCollection();
        $this->resourceAlterations = new ArrayCollection();
        $this->damageOverTimes = new ArrayCollection();
        $this->healOverTimes = new ArrayCollection();
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
     * @return Collection|AttributeAlteration[]
     */
    public function getAttributeAlterations(): Collection
    {
        return $this->attributeAlterations;
    }

    public function addAttributeAlteration(AttributeAlteration $attributeAlteration): self
    {
        if (!$this->attributeAlterations->contains($attributeAlteration)) {
            $this->attributeAlterations[] = $attributeAlteration;
            $attributeAlteration->setStatusEffect($this);
        }

        return $this;
    }

    public function removeAttributeAlteration(AttributeAlteration $attributeAlteration): self
    {
        if ($this->attributeAlterations->contains($attributeAlteration)) {
            $this->attributeAlterations->removeElement($attributeAlteration);
            // set the owning side to null (unless already changed)
            if ($attributeAlteration->getStatusEffect() === $this) {
                $attributeAlteration->setStatusEffect(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ResourceAlteration[]
     */
    public function getResourceAlterations(): Collection
    {
        return $this->resourceAlterations;
    }

    public function addResourceAlteration(ResourceAlteration $resourceAlteration): self
    {
        if (!$this->resourceAlterations->contains($resourceAlteration)) {
            $this->resourceAlterations[] = $resourceAlteration;
            $resourceAlteration->setStatusEffect($this);
        }

        return $this;
    }

    public function removeResourceAlteration(ResourceAlteration $resourceAlteration): self
    {
        if ($this->resourceAlterations->contains($resourceAlteration)) {
            $this->resourceAlterations->removeElement($resourceAlteration);
            // set the owning side to null (unless already changed)
            if ($resourceAlteration->getStatusEffect() === $this) {
                $resourceAlteration->setStatusEffect(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DamageOverTime[]
     */
    public function getDamageOverTimes(): Collection
    {
        return $this->damageOverTimes;
    }

    public function addDamageOverTime(DamageOverTime $damageOverTime): self
    {
        if (!$this->damageOverTimes->contains($damageOverTime)) {
            $this->damageOverTimes[] = $damageOverTime;
            $damageOverTime->setStatusEffect($this);
        }

        return $this;
    }

    public function removeDamageOverTime(DamageOverTime $damageOverTime): self
    {
        if ($this->damageOverTimes->contains($damageOverTime)) {
            $this->damageOverTimes->removeElement($damageOverTime);
            // set the owning side to null (unless already changed)
            if ($damageOverTime->getStatusEffect() === $this) {
                $damageOverTime->setStatusEffect(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HealOverTime[]
     */
    public function getHealOverTimes(): Collection
    {
        return $this->healOverTimes;
    }

    public function addHealOverTime(HealOverTime $healOverTime): self
    {
        if (!$this->healOverTimes->contains($healOverTime)) {
            $this->healOverTimes[] = $healOverTime;
            $healOverTime->setStatusEffect($this);
        }

        return $this;
    }

    public function removeHealOverTime(HealOverTime $healOverTime): self
    {
        if ($this->healOverTimes->contains($healOverTime)) {
            $this->healOverTimes->removeElement($healOverTime);
            // set the owning side to null (unless already changed)
            if ($healOverTime->getStatusEffect() === $this) {
                $healOverTime->setStatusEffect(null);
            }
        }

        return $this;
    }
}
