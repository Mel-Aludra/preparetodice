<?php

namespace App\Entity;

use App\Repository\CharacterStatusEffectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacterStatusEffectRepository::class)
 */
class CharacterStatusEffect extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=GameCharacter::class, inversedBy="characterStatusEffects")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?GameCharacter $gameCharacter;

    /**
     * @ORM\ManyToOne(targetEntity=StatusEffect::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?StatusEffect $statusEffect;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $remainingTurns;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $wipeIfReset;

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

    public function getStatusEffect(): ?StatusEffect
    {
        return $this->statusEffect;
    }

    public function setStatusEffect(?StatusEffect $statusEffect): self
    {
        $this->statusEffect = $statusEffect;

        return $this;
    }

    public function getRemainingTurns(): ?int
    {
        return $this->remainingTurns;
    }

    public function setRemainingTurns(?int $remainingTurns): self
    {
        $this->remainingTurns = $remainingTurns;

        return $this;
    }

    public function getWipeIfReset(): ?bool
    {
        return $this->wipeIfReset;
    }

    public function setWipeIfReset(bool $wipeIfReset): self
    {
        $this->wipeIfReset = $wipeIfReset;

        return $this;
    }
}
