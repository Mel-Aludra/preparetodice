<?php

namespace App\Entity;

use App\Repository\InventoryWeaponRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventoryWeaponRepository::class)
 */
class InventoryWeapon extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=GameCharacter::class, inversedBy="inventoryWeapons")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?GameCharacter $gameCharacter;

    /**
     * @ORM\ManyToOne(targetEntity=Weapon::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Weapon $weapon;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $quantity;

    /**
     * @ORM\OneToMany(targetEntity=GameCharacter::class, mappedBy="equippedWeapon")
     */
    private $gameCharacters;

    public function __construct()
    {
        $this->gameCharacters = new ArrayCollection();
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

    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    public function setWeapon(?Weapon $weapon): self
    {
        $this->weapon = $weapon;

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
     * @return Collection|GameCharacter[]
     */
    public function getGameCharacters(): Collection
    {
        return $this->gameCharacters;
    }

    public function addGameCharacter(GameCharacter $gameCharacter): self
    {
        if (!$this->gameCharacters->contains($gameCharacter)) {
            $this->gameCharacters[] = $gameCharacter;
            $gameCharacter->setEquippedWeapon($this);
        }

        return $this;
    }

    public function removeGameCharacter(GameCharacter $gameCharacter): self
    {
        if ($this->gameCharacters->contains($gameCharacter)) {
            $this->gameCharacters->removeElement($gameCharacter);
            // set the owning side to null (unless already changed)
            if ($gameCharacter->getEquippedWeapon() === $this) {
                $gameCharacter->setEquippedWeapon(null);
            }
        }

        return $this;
    }
}
