<?php

namespace App\Entity;

use App\Repository\CharacterResourceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacterResourceRepository::class)
 */
class CharacterResource extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=GameCharacter::class, inversedBy="characterResources")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?GameCharacter $gameCharacter;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $active;

    /**
     * @ORM\ManyToOne(targetEntity=Resource::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Resource $resource;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $value;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $finalValue;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $currentValue;

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

    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    public function setResource(?Resource $resource): self
    {
        $this->resource = $resource;

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

    public function getCurrentValue(): ?int
    {
        return $this->currentValue;
    }

    public function setCurrentValue(int $currentValue): self
    {
        $this->currentValue = $currentValue;

        return $this;
    }

    /**
     * @return int
     */
    public function getPercent() :int
    {
        if($this->getFinalValue() > 0) {
            return round(($this->getCurrentValue() / $this->getFinalValue()) * 100);
        }
        return 0;
    }
}
