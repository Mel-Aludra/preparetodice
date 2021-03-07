<?php

namespace App\Entity;

use App\Repository\InventoryGearRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventoryGearRepository::class)
 */
class InventoryGear extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=GameCharacter::class, inversedBy="inventoryGears")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?GameCharacter $gameCharacter;

    /**
     * @ORM\ManyToOne(targetEntity=Gear::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Gear $gear;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $quantity;

    /**
     * @ORM\OneToMany(targetEntity=EquippedGear::class, mappedBy="inventoryGear", orphanRemoval=true)
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

    public function getGameCharacter(): ?GameCharacter
    {
        return $this->gameCharacter;
    }

    public function setGameCharacter(?GameCharacter $gameCharacter): self
    {
        $this->gameCharacter = $gameCharacter;

        return $this;
    }

    public function getGear(): ?Gear
    {
        return $this->gear;
    }

    public function setGear(?Gear $gear): self
    {
        $this->gear = $gear;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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
            $equippedGear->setInventoryGear($this);
        }

        return $this;
    }

    public function removeEquippedGear(EquippedGear $equippedGear): self
    {
        if ($this->equippedGears->contains($equippedGear)) {
            $this->equippedGears->removeElement($equippedGear);
            // set the owning side to null (unless already changed)
            if ($equippedGear->getInventoryGear() === $this) {
                $equippedGear->setInventoryGear(null);
            }
        }

        return $this;
    }

    /**
     * @param EquipmentSlot $equipmentSlot
     * @return bool
     */
    public function isEquippedToSlot(EquipmentSlot $equipmentSlot) :bool
    {
        foreach($this->getEquippedGears() as $equippedGear) {
            if($equippedGear->getEquipmentSlot()->getId() === $equipmentSlot->getId())
                return true;
        }
        return false;
    }
}
