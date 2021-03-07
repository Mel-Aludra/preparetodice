<?php

namespace App\Entity;

use App\Repository\EquipmentSlotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipmentSlotRepository::class)
 */
class EquipmentSlot extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="equipmentSlots")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Game $game;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\OneToMany(targetEntity=EquippedGear::class, mappedBy="equipmentSlot", orphanRemoval=true)
     */
    private $equippedGears;

    public function __construct()
    {
        $this->equippedGears = new ArrayCollection();
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

    /**
     * @return Collection|EquippedGear[]
     */
    public function getEquippedGears(): Collection
    {
        return $this->equippedGears;
    }

    public function addEquippedGear(EquippedGear $equippedGear): self
    {
        if (!$this->equippedGears->contains($equippedGear)) {
            $this->equippedGears[] = $equippedGear;
            $equippedGear->setEquipmentSlot($this);
        }

        return $this;
    }

    public function removeEquippedGear(EquippedGear $equippedGear): self
    {
        if ($this->equippedGears->contains($equippedGear)) {
            $this->equippedGears->removeElement($equippedGear);
            // set the owning side to null (unless already changed)
            if ($equippedGear->getEquipmentSlot() === $this) {
                $equippedGear->setEquipmentSlot(null);
            }
        }

        return $this;
    }
}
