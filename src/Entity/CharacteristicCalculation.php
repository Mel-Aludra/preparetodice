<?php

namespace App\Entity;

use App\Repository\CharacteristicCalculationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacteristicCalculationRepository::class)
 */
class CharacteristicCalculation extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=GameCharacter::class, inversedBy="characteristicCalculations")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?GameCharacter $gameCharacter;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $poolNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $source;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?int $isNegative;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $characteristic;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $calculation;

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

    public function getPoolNumber(): ?int
    {
        return $this->poolNumber;
    }

    public function setPoolNumber(int $poolNumber): self
    {
        $this->poolNumber = $poolNumber;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getIsNegative(): ?bool
    {
        return $this->isNegative;
    }

    public function setIsNegative(bool $isNegative): self
    {
        $this->isNegative = $isNegative;

        return $this;
    }

    public function getCharacteristic(): ?string
    {
        return $this->characteristic;
    }

    public function setCharacteristic(string $characteristic): self
    {
        $this->characteristic = $characteristic;

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

    public function getCalculation(): ?string
    {
        return $this->calculation;
    }

    public function setCalculation(string $calculation): self
    {
        $this->calculation = $calculation;

        return $this;
    }
}
