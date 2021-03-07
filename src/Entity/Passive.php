<?php

namespace App\Entity;

use App\Repository\PassiveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PassiveRepository::class)
 */
class Passive extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="passives")
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
     * @ORM\OneToMany(targetEntity=DamageOverTime::class, mappedBy="passive")
     */
    private $damageOverTimes;

    /**
     * @ORM\OneToMany(targetEntity=HealOverTime::class, mappedBy="passive")
     */
    private $healOverTimes;

    /**
     * @ORM\OneToMany(targetEntity=ResourceAlteration::class, mappedBy="passive")
     */
    private $resourceAlterations;

    /**
     * @ORM\OneToMany(targetEntity=AttributeAlteration::class, mappedBy="passive")
     */
    private $attributeAlterations;

    /**
     * @ORM\OneToMany(targetEntity=CharacterPassive::class, mappedBy="passive", orphanRemoval=true)
     */
    private $characterPassives;

    public function __construct()
    {
        $this->damageOverTimes = new ArrayCollection();
        $this->healOverTimes = new ArrayCollection();
        $this->resourceAlterations = new ArrayCollection();
        $this->attributeAlterations = new ArrayCollection();
        $this->characterPassives = new ArrayCollection();
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
            $damageOverTime->setPassive($this);
        }

        return $this;
    }

    public function removeDamageOverTime(DamageOverTime $damageOverTime): self
    {
        if ($this->damageOverTimes->contains($damageOverTime)) {
            $this->damageOverTimes->removeElement($damageOverTime);
            // set the owning side to null (unless already changed)
            if ($damageOverTime->getPassive() === $this) {
                $damageOverTime->setPassive(null);
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
            $healOverTime->setPassive($this);
        }

        return $this;
    }

    public function removeHealOverTime(HealOverTime $healOverTime): self
    {
        if ($this->healOverTimes->contains($healOverTime)) {
            $this->healOverTimes->removeElement($healOverTime);
            // set the owning side to null (unless already changed)
            if ($healOverTime->getPassive() === $this) {
                $healOverTime->setPassive(null);
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
            $resourceAlteration->setPassive($this);
        }

        return $this;
    }

    public function removeResourceAlteration(ResourceAlteration $resourceAlteration): self
    {
        if ($this->resourceAlterations->contains($resourceAlteration)) {
            $this->resourceAlterations->removeElement($resourceAlteration);
            // set the owning side to null (unless already changed)
            if ($resourceAlteration->getPassive() === $this) {
                $resourceAlteration->setPassive(null);
            }
        }

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
            $attributeAlteration->setPassive($this);
        }

        return $this;
    }

    public function removeAttributeAlteration(AttributeAlteration $attributeAlteration): self
    {
        if ($this->attributeAlterations->contains($attributeAlteration)) {
            $this->attributeAlterations->removeElement($attributeAlteration);
            // set the owning side to null (unless already changed)
            if ($attributeAlteration->getPassive() === $this) {
                $attributeAlteration->setPassive(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CharacterPassive[]
     */
    public function getCharacterPassives(): Collection
    {
        return $this->characterPassives;
    }

    public function addCharacterPassive(CharacterPassive $characterPassife): self
    {
        if (!$this->characterPassives->contains($characterPassife)) {
            $this->characterPassives[] = $characterPassife;
            $characterPassife->setPassive($this);
        }

        return $this;
    }

    public function removeCharacterPassive(CharacterPassive $characterPassife): self
    {
        if ($this->characterPassives->contains($characterPassife)) {
            $this->characterPassives->removeElement($characterPassife);
            // set the owning side to null (unless already changed)
            if ($characterPassife->getPassive() === $this) {
                $characterPassife->setPassive(null);
            }
        }

        return $this;
    }
}
