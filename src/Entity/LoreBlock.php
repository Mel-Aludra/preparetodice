<?php

namespace App\Entity;

use App\Repository\LoreBlockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoreBlockRepository::class)
 */
class LoreBlock extends Entity
{

    const PUBLIC_ACCESS = "public";
    const HIDDEN_ACCESS = "hidden";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="loreBlocks")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Game $game;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $accessType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title;

    /**
     * @ORM\OneToMany(targetEntity=LoreBlockElement::class, mappedBy="loreBlock", orphanRemoval=true)
     */
    private Collection $loreBlockElements;

    /**
     * @ORM\ManyToMany(targetEntity=GameCharacter::class, mappedBy="loreBlocks")
     */
    private Collection $gameCharacters;

    /**
     * @ORM\ManyToOne(targetEntity=LoreTag::class, inversedBy="relatedBlocks")
     */
    private $tag;

    public function __construct()
    {
        $this->loreBlockElements = new ArrayCollection();
        $this->gameCharacters = new ArrayCollection();
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

    public function getAccessType(): ?string
    {
        return $this->accessType;
    }

    public function setAccessType(string $accessType): self
    {
        $this->accessType = $accessType;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|LoreBlockElement[]
     */
    public function getLoreBlockElements(): Collection
    {
        return $this->loreBlockElements;
    }

    public function addLoreBlockElement(LoreBlockElement $loreBlockElement): self
    {
        if (!$this->loreBlockElements->contains($loreBlockElement)) {
            $this->loreBlockElements[] = $loreBlockElement;
            $loreBlockElement->setLoreBlock($this);
        }

        return $this;
    }

    public function removeLoreBlockElement(LoreBlockElement $loreBlockElement): self
    {
        if ($this->loreBlockElements->contains($loreBlockElement)) {
            $this->loreBlockElements->removeElement($loreBlockElement);
            // set the owning side to null (unless already changed)
            if ($loreBlockElement->getLoreBlock() === $this) {
                $loreBlockElement->setLoreBlock(null);
            }
        }

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
            $gameCharacter->addLoreBlock($this);
        }

        return $this;
    }

    public function removeGameCharacter(GameCharacter $gameCharacter): self
    {
        if ($this->gameCharacters->contains($gameCharacter)) {
            $this->gameCharacters->removeElement($gameCharacter);
            $gameCharacter->removeLoreBlock($this);
        }

        return $this;
    }

    public function getTag(): ?LoreTag
    {
        return $this->tag;
    }

    public function setTag(?LoreTag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

}
