<?php

namespace App\Entity;

use App\Repository\CharacterAttributeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacterAttributeRepository::class)
 */
class CharacterAttribute extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=GameCharacter::class, inversedBy="characterAttributes")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?GameCharacter $gameCharacter;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $active;

    /**
     * @ORM\ManyToOne(targetEntity=Attribute::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Attribute $attribute;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $value;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $finalValue;

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getAttribute(): ?Attribute
    {
        return $this->attribute;
    }

    public function setAttribute(?Attribute $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getFinalValue(): ?int
    {
        return $this->finalValue;
    }

    public function setFinalValue(int $finalValue): self
    {
        $this->finalValue = $finalValue;

        return $this;
    }
}
