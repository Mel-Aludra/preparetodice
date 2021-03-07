<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Email already taken"
 * )
 * @UniqueEntity(
 *     fields={"name"},
 *     message="User name already taken"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @Assert\NotBlank(message="User name can't be empty.")
     * @Assert\Length(min=3, max=255, minMessage="User name length can't be lesser than 3 characters.", maxMessage="User name length can't be greater than 255 characters.")
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @Assert\NotBlank(message="Email can't be empty.")
     * @Assert\Email(message="Email is not valid.")
     * @ORM\Column(type="string", length=255)
     */
    private ?string $email;

    /**
     * @Assert\NotBlank(message="Password can't be empty.")
     * @Assert\Length(min=8, max=255, minMessage="Password can't be lesser than 8 characters.", maxMessage="Password can't be greater than 255 characters.")
     * @ORM\Column(type="string", length=255)
     */
    private ?string $password;

    /**
     * @ORM\OneToMany(targetEntity=UserGame::class, mappedBy="user", orphanRemoval=true)
     */
    private Collection $userGames;

    /**
     * @ORM\OneToMany(targetEntity=Invitation::class, mappedBy="user", orphanRemoval=true)
     */
    private $invitations;

    /**
     * @ORM\OneToMany(targetEntity=PasswordReset::class, mappedBy="user", orphanRemoval=true)
     */
    private $passwordResets;

    public function __construct()
    {
        $this->userGames = new ArrayCollection();
        $this->invitations = new ArrayCollection();
        $this->passwordResets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getUsername()
    {
        return $this->getName();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @return Collection|UserGame[]
     */
    public function getUserGames(): Collection
    {
        return $this->userGames;
    }

    public function addUserGame(UserGame $userGame): self
    {
        if (!$this->userGames->contains($userGame)) {
            $this->userGames[] = $userGame;
            $userGame->setUser($this);
        }

        return $this;
    }

    public function removeUserGame(UserGame $userGame): self
    {
        if ($this->userGames->contains($userGame)) {
            $this->userGames->removeElement($userGame);
            // set the owning side to null (unless already changed)
            if ($userGame->getUser() === $this) {
                $userGame->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @param Game $game
     * @return array
     */
    public function getGameCharacters(Game $game)
    {
        $characters = [];
        foreach($this->getUserGames() as $userGame) {
            if($userGame->getGame()->getId() === $game->getId()) {
                foreach($userGame->getUserGameCharacters() as $userGameCharacter) {
                    $characters[] = $userGameCharacter->getGameCharacter();
                }
            }
        }
        return $characters;
    }

    /**
     * @return Collection|Invitation[]
     */
    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(Invitation $invitation): self
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations[] = $invitation;
            $invitation->setUser($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): self
    {
        if ($this->invitations->contains($invitation)) {
            $this->invitations->removeElement($invitation);
            // set the owning side to null (unless already changed)
            if ($invitation->getUser() === $this) {
                $invitation->setUser(null);
            }
        }

        return $this;
    }

    public function isGameMaster(int $gameId)
    {
        foreach($this->getUserGames() as $userGame) {
            if($userGame->getGame()->getId() === $gameId) {
                if($userGame->getAccessType() === UserGame::GM_ACCESS || $userGame->getAccessType() === UserGame::OWNER_ACCESS)
                    return true;
            }
        }
        return false;
    }

    /**
     * @return Collection|PasswordReset[]
     */
    public function getPasswordResets(): Collection
    {
        return $this->passwordResets;
    }

    public function addPasswordReset(PasswordReset $passwordReset): self
    {
        if (!$this->passwordResets->contains($passwordReset)) {
            $this->passwordResets[] = $passwordReset;
            $passwordReset->setUser($this);
        }

        return $this;
    }

    public function removePasswordReset(PasswordReset $passwordReset): self
    {
        if ($this->passwordResets->contains($passwordReset)) {
            $this->passwordResets->removeElement($passwordReset);
            // set the owning side to null (unless already changed)
            if ($passwordReset->getUser() === $this) {
                $passwordReset->setUser(null);
            }
        }

        return $this;
    }

}
