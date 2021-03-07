<?php

namespace App\Entity;

use App\Repository\DefenseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DefenseRepository::class)
 */
class Defense extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Attribute::class, inversedBy="defenses")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Attribute $attribute;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $efficiency;

    /**
     * @ORM\ManyToOne(targetEntity=DamageNature::class, inversedBy="defenses")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?DamageNature $damageNature;

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

    public function getEfficiency(): ?int
    {
        return $this->efficiency;
    }

    public function setEfficiency(int $efficiency): self
    {
        $this->efficiency = $efficiency;

        return $this;
    }

    public function getDamageNature(): ?DamageNature
    {
        return $this->damageNature;
    }

    public function setDamageNature(?DamageNature $damageNature): self
    {
        $this->damageNature = $damageNature;

        return $this;
    }
}
