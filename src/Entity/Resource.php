<?php

namespace App\Entity;

use App\Repository\ResourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResourceRepository::class)
 */
class Resource extends Entity
{

    const IS_REVERSED_DIRECTION_CHOICES = [
        "Resource goes from maximum value to 0 (mana or life point, for examples)" => false,
        "Resource goes from 0 to maximum value (rage or focus, for examples)" => true
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="resources")
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
     * @ORM\Column(type="boolean")
     */
    private ?bool $isReversedDirection;

    /**
     * @ORM\ManyToOne(targetEntity=Color::class)
     */
    private ?Color $color;

    /**
     * @ORM\OneToMany(targetEntity=AttributeEffect::class, mappedBy="resource", orphanRemoval=true)
     */
    private ?Collection $attributeEffects;

    /**
     * @ORM\ManyToMany(targetEntity=Job::class, inversedBy="resources")
     */
    private ?Collection $jobs;

    public function __construct()
    {
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

    public function getIsReversedDirection(): ?bool
    {
        return $this->isReversedDirection;
    }

    public function setIsReversedDirection(bool $isReversedDirection): self
    {
        $this->isReversedDirection = $isReversedDirection;

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
            $attributeEffect->setResource($this);
        }

        return $this;
    }

    public function removeAttributeEffect(AttributeEffect $attributeEffect): self
    {
        if ($this->attributeEffects->contains($attributeEffect)) {
            $this->attributeEffects->removeElement($attributeEffect);
            // set the owning side to null (unless already changed)
            if ($attributeEffect->getResource() === $this) {
                $attributeEffect->setResource(null);
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
