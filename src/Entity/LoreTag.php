<?php

namespace App\Entity;

use App\Repository\LoreTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoreTagRepository::class)
 */
class LoreTag extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="loreTags")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Game $game;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $sort;

    /**
     * @ORM\OneToMany(targetEntity=LoreBlock::class, mappedBy="tag")
     */
    private ?Collection $relatedBlocks;

    public function __construct()
    {
        $this->relatedBlocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(Game $game): self
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

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return Collection|LoreBlock[]
     */
    public function getRelatedBlocks(): Collection
    {
        return $this->relatedBlocks;
    }

    public function addRelatedBlock(LoreBlock $relatedBlock): self
    {
        if (!$this->relatedBlocks->contains($relatedBlock)) {
            $this->relatedBlocks[] = $relatedBlock;
            $relatedBlock->setTag($this);
        }

        return $this;
    }

    public function removeRelatedBlock(LoreBlock $relatedBlock): self
    {
        if ($this->relatedBlocks->contains($relatedBlock)) {
            $this->relatedBlocks->removeElement($relatedBlock);
            // set the owning side to null (unless already changed)
            if ($relatedBlock->getTag() === $this) {
                $relatedBlock->setTag(null);
            }
        }

        return $this;
    }
}
