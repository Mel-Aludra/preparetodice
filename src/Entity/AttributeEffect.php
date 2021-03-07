<?php

namespace App\Entity;

use App\Repository\AttributeEffectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttributeEffectRepository::class)
 */
class AttributeEffect extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Attribute::class, inversedBy="attributeEffects")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Attribute $attribute;

    /**
     * @ORM\ManyToOne(targetEntity=Resource::class, inversedBy="attributeEffects")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Resource $resource;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isNegative;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $valuePerPoint;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttribute(): ?Attribute
    {
        return $this->attribute;
    }

    public function setAttribute(?Attribute $attribute): self
    {
        $this->attribute = $attribute;

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

    public function getIsNegative(): ?bool
    {
        return $this->isNegative;
    }

    public function setIsNegative(bool $isNegative): self
    {
        $this->isNegative = $isNegative;

        return $this;
    }

    public function getValuePerPoint(): ?int
    {
        return $this->valuePerPoint;
    }

    public function setValuePerPoint(int $valuePerPoint): self
    {
        $this->valuePerPoint = $valuePerPoint;

        return $this;
    }
}
