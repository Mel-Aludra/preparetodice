<?php

namespace App\Entity;

use App\Repository\LoreBlockElementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoreBlockElementRepository::class)
 */
class LoreBlockElement extends Entity
{

    const PUBLIC_ACCESS = "public";
    const RELATED_ACCESS = "related";
    const HIDDEN_ACCESS = "hidden";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=LoreBlock::class, inversedBy="loreBlockElements")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?LoreBlock $loreBlock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $accessType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $text;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoreBlock(): ?LoreBlock
    {
        return $this->loreBlock;
    }

    public function setLoreBlock(?LoreBlock $loreBlock): self
    {
        $this->loreBlock = $loreBlock;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
