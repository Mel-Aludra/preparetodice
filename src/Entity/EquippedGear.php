<?php

namespace App\Entity;

use App\Repository\EquippedGearRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquippedGearRepository::class)
 */
class EquippedGear extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=GameCharacter::class, inversedBy="equippedGears")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?GameCharacter $gameCharacter;

    /**
     * @ORM\ManyToOne(targetEntity=EquipmentSlot::class, inversedBy="equippedGears")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?EquipmentSlot $equipmentSlot;

    /**
     * @ORM\ManyToOne(targetEntity=InventoryGear::class, inversedBy="equippedGears")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?InventoryGear $inventoryGear = null;

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

    public function getEquipmentSlot(): ?EquipmentSlot
    {
        return $this->equipmentSlot;
    }

    public function setEquipmentSlot(?EquipmentSlot $equipmentSlot): self
    {
        $this->equipmentSlot = $equipmentSlot;

        return $this;
    }

    public function getInventoryGear(): ?InventoryGear
    {
        return $this->inventoryGear;
    }

    public function setInventoryGear(?InventoryGear $inventoryGear): self
    {
        $this->inventoryGear = $inventoryGear;

        return $this;
    }
}
