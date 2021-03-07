<?php

namespace App\Entity;

use App\Repository\UserGameCharacterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserGameCharacterRepository::class)
 */
class UserGameCharacter extends Entity
{

    const READ_ACCESS = "read";
    const EDIT_ACCESS = "edit";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=UserGame::class, inversedBy="userGameCharacters")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?UserGame $userGame;

    /**
     * @ORM\ManyToOne(targetEntity=GameCharacter::class, inversedBy="userGameCharacters")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?GameCharacter $gameCharacter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $accessType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserGame(): ?UserGame
    {
        return $this->userGame;
    }

    public function setUserGame(?UserGame $userGame): self
    {
        $this->userGame = $userGame;

        return $this;
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

    public function getAccessType(): ?string
    {
        return $this->accessType;
    }

    public function setAccessType(string $accessType): self
    {
        $this->accessType = $accessType;

        return $this;
    }
}
