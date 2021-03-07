<?php

namespace App\Entity;

use App\Repository\AttributeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttributeRepository::class)
 *
 */
class Attribute extends Entity
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="attributes")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Game $game;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private ?string $abreviation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $maximumValue;

    /**
     * @ORM\OneToMany(targetEntity=Defense::class, mappedBy="attribute", orphanRemoval=true)
     */
    private ?Collection $defenses;

    /**
     * @ORM\ManyToOne(targetEntity=Color::class)
     */
    private ?Color $color;

    /**
     * @ORM\OneToMany(targetEntity=PotencyAugmentator::class, mappedBy="attribute", orphanRemoval=true)
     */
    private ?Collection $potencyAugmentators;

    /**
     * @ORM\OneToMany(targetEntity=AttributeEffect::class, mappedBy="attribute", orphanRemoval=true)
     */
    private ?Collection $attributeEffects;

    /**
     * @ORM\ManyToMany(targetEntity=Job::class, inversedBy="attributes")
     */
    private ?Collection $jobs;

    public function __construct()
    {
        $this->defenses = new ArrayCollection();
        $this->potencyAugmentators = new ArrayCollection();
        $this->attributeEffects = new ArrayCollection();
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

    public function getAbreviation(): ?string
    {
        return $this->abreviation;
    }

    public function setAbreviation(string $abreviation): self
    {
        $this->abreviation = $abreviation;

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

    public function getMaximumValue(): ?int
    {
        return $this->maximumValue;
    }

    public function setMaximumValue(?int $maximumValue): self
    {
        $this->maximumValue = $maximumValue;

        return $this;
    }

    /**
     * @return Collection|Defense[]
     */
    public function getDefenses(): Collection
    {
        return $this->defenses;
    }

    public function addDefense(Defense $defense): self
    {
        if (!$this->defenses->contains($defense)) {
            $this->defenses[] = $defense;
            $defense->setAttribute($this);
        }

        return $this;
    }

    public function removeDefense(Defense $defense): self
    {
        if ($this->defenses->contains($defense)) {
            $this->defenses->removeElement($defense);
            // set the owning side to null (unless already changed)
            if ($defense->getAttribute() === $this) {
                $defense->setAttribute(null);
            }
        }

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|PotencyAugmentator[]
     */
    public function getPotencyAugmentators(): Collection
    {
        return $this->potencyAugmentators;
    }

    public function addPotencyAugmentator(PotencyAugmentator $potencyAugmentator): self
    {
        if (!$this->potencyAugmentators->contains($potencyAugmentator)) {
            $this->potencyAugmentators[] = $potencyAugmentator;
            $potencyAugmentator->setAttribute($this);
        }

        return $this;
    }

    public function removePotencyAugmentator(PotencyAugmentator $potencyAugmentator): self
    {
        if ($this->potencyAugmentators->contains($potencyAugmentator)) {
            $this->potencyAugmentators->removeElement($potencyAugmentator);
            // set the owning side to null (unless already changed)
            if ($potencyAugmentator->getAttribute() === $this) {
                $potencyAugmentator->setAttribute(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AttributeEffect[]
     */
    public function getAttributeEffects(): Collection
    {
        return $this->attributeEffects;
    }

    public function addAttributeEffect(AttributeEffect $attributeEffect): self
    {
        if (!$this->attributeEffects->contains($attributeEffect)) {
            $this->attributeEffects[] = $attributeEffect;
            $attributeEffect->setAttribute($this);
        }

        return $this;
    }

    public function removeAttributeEffect(AttributeEffect $attributeEffect): self
    {
        if ($this->attributeEffects->contains($attributeEffect)) {
            $this->attributeEffects->removeElement($attributeEffect);
            // set the owning side to null (unless already changed)
            if ($attributeEffect->getAttribute() === $this) {
                $attributeEffect->setAttribute(null);
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
