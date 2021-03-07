<?php

namespace App\Entity;

use App\Repository\CharacterPassiveRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacterPassiveRepository::class)
 */
class CharacterPassive extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=GameCharacter::class, inversedBy="characterPassives")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?GameCharacter $gameCharacter;

    /**
     * @ORM\ManyToOne(targetEntity=Passive::class, inversedBy="characterPassives")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Passive $passive;

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

    public function getPassive(): ?Passive
    {
        return $this->passive;
    }

    public function setPassive(?Passive $passive): self
    {
        $this->passive = $passive;

        return $this;
    }
}
