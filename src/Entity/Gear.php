<?php

namespace App\Entity;

use App\Repository\GearRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GearRepository::class)
 */
class Gear extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="gears")
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
     * @ORM\OneToMany(targetEntity=DamageOverTime::class, mappedBy="gear")
     */
    private ?Collection $damageOverTimes;

    /**
     * @ORM\OneToMany(targetEntity=HealOverTime::class, mappedBy="gear")
     */
    private ?Collection $healOverTimes;

    /**
     * @ORM\OneToMany(targetEntity=ResourceAlteration::class, mappedBy="gear")
     */
    private ?Collection $resourceAlterations;

    /**
     * @ORM\OneToMany(targetEntity=AttributeAlteration::class, mappedBy="gear")
     */
    private ?Collection $attributeAlterations;

    /**
     * @ORM\ManyToMany(targetEntity=Job::class, inversedBy="gears")
     */
    private $jobs;

    public function __construct()
    {
        $this->damageOverTimes = new ArrayCollection();
        $this->healOverTimes = new ArrayCollection();
        $this->resourceAlterations = new ArrayCollection();
        $this->attributeAlterations = new ArrayCollection();
        $this->jobs = new ArrayCollection();
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
            $damageOverTime->setGear($this);
        }

        return $this;
    }

    public function removeDamageOverTime(DamageOverTime $damageOverTime): self
    {
        if ($this->damageOverTimes->contains($damageOverTime)) {
            $this->damageOverTimes->removeElement($damageOverTime);
            // set the owning side to null (unless already changed)
            if ($damageOverTime->getGear() === $this) {
                $damageOverTime->setGear(null);
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
            $healOverTime->setGear($this);
        }

        return $this;
    }

    public function removeHealOverTime(HealOverTime $healOverTime): self
    {
        if ($this->healOverTimes->contains($healOverTime)) {
            $this->healOverTimes->removeElement($healOverTime);
            // set the owning side to null (unless already changed)
            if ($healOverTime->getGear() === $this) {
                $healOverTime->setGear(null);
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
            $resourceAlteration->setGear($this);
        }

        return $this;
    }

    public function removeResourceAlteration(ResourceAlteration $resourceAlteration): self
    {
        if ($this->resourceAlterations->contains($resourceAlteration)) {
            $this->resourceAlterations->removeElement($resourceAlteration);
            // set the owning side to null (unless already changed)
            if ($resourceAlteration->getGear() === $this) {
                $resourceAlteration->setGear(null);
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
            $attributeAlteration->setGear($this);
        }

        return $this;
    }

    public function removeAttributeAlteration(AttributeAlteration $attributeAlteration): self
    {
        if ($this->attributeAlterations->contains($attributeAlteration)) {
            $this->attributeAlterations->removeElement($attributeAlteration);
            // set the owning side to null (unless already changed)
            if ($attributeAlteration->getGear() === $this) {
                $attributeAlteration->setGear(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Job[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs[] = $job;
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
        }

        return $this;
    }
}
