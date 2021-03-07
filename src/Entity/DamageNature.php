<?php

namespace App\Entity;

use App\Repository\DamageNatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DamageNatureRepository::class)
 */
class DamageNature extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="damageNatures")
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
     * @ORM\OneToMany(targetEntity=Defense::class, mappedBy="damageNature", orphanRemoval=true)
     */
    private ?Collection $defenses;

    public function __construct()
    {
        $this->defenses = new ArrayCollection();
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
            $defense->setDamageNature($this);
        }

        return $this;
    }

    public function removeDefense(Defense $defense): self
    {
        if ($this->defenses->contains($defense)) {
            $this->defenses->removeElement($defense);
            // set the owning side to null (unless already changed)
            if ($defense->getDamageNature() === $this) {
                $defense->setDamageNature(null);
            }
        }

        return $this;
    }
}
