<?php

namespace App\Entity;

use App\Repository\UserGameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserGameRepository::class)
 */
class UserGame extends Entity
{

    const PLAYER_ACCESS = "player";
    const GM_ACCESS = "master";
    const OWNER_ACCESS = "owner";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userGames")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="userGames")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Game $game;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $accessType;

    /**
     * @ORM\OneToMany(targetEntity=UserGameCharacter::class, mappedBy="userGame", orphanRemoval=true)
     */
    private Collection $userGameCharacters;

    public function __construct()
    {
        $this->userGameCharacters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

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

    /**
     * @return Collection|UserGameCharacter[]
     */
    public function getUserGameCharacters(): Collection
    {
        return $this->userGameCharacters;
    }

    public function addUserGameCharacter(UserGameCharacter $userGameCharacter): self
    {
        if (!$this->userGameCharacters->contains($userGameCharacter)) {
            $this->userGameCharacters[] = $userGameCharacter;
            $userGameCharacter->setUserGame($this);
        }

        return $this;
    }

    public function removeUserGameCharacter(UserGameCharacter $userGameCharacter): self
    {
        if ($this->userGameCharacters->contains($userGameCharacter)) {
            $this->userGameCharacters->removeElement($userGameCharacter);
            // set the owning side to null (unless already changed)
            if ($userGameCharacter->getUserGame() === $this) {
                $userGameCharacter->setUserGame(null);
            }
        }

        return $this;
    }
}
