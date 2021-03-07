<?php

namespace App\Entity;

use App\Repository\BattleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BattleRepository::class)
 */
class Battle extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="battles")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Game $game;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $turnsNumber;

    /**
     * @ORM\OneToMany(targetEntity=Action::class, mappedBy="battle", orphanRemoval=true)
     */
    private $actions;

    /**
     * @ORM\OneToMany(targetEntity=BattleLog::class, mappedBy="battle")
     */
    private $battleLogs;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
        $this->battleLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTurnsNumber(): ?int
    {
        return $this->turnsNumber;
    }

    public function setTurnsNumber(int $turnsNumber): self
    {
        $this->turnsNumber = $turnsNumber;

        return $this;
    }

    /**
     * @return Collection|Action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setBattle($this);
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
            // set the owning side to null (unless already changed)
            if ($action->getBattle() === $this) {
                $action->setBattle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BattleLog[]
     */
    public function getBattleLogs(): Collection
    {
        return $this->battleLogs;
    }

    public function addBattleLog(BattleLog $battleLog): self
    {
        if (!$this->battleLogs->contains($battleLog)) {
            $this->battleLogs[] = $battleLog;
            $battleLog->setBattle($this);
        }

        return $this;
    }

    public function removeBattleLog(BattleLog $battleLog): self
    {
        if ($this->battleLogs->contains($battleLog)) {
            $this->battleLogs->removeElement($battleLog);
            // set the owning side to null (unless already changed)
            if ($battleLog->getBattle() === $this) {
                $battleLog->setBattle(null);
            }
        }

        return $this;
    }
}
