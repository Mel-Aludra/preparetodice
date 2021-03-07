<?php

namespace App\Entity;

use App\Repository\InventoryConsumableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventoryConsumableRepository::class)
 */
class InventoryConsumable extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=GameCharacter::class, inversedBy="inventoryConsumables")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?GameCharacter $gameCharacter;

    /**
     * @ORM\ManyToOne(targetEntity=Consumable::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Consumable $consumable;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $quantity;

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

    public function getConsumable(): ?Consumable
    {
        return $this->consumable;
    }

    public function setConsumable(?Consumable $consumable): self
    {
        $this->consumable = $consumable;

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
}
