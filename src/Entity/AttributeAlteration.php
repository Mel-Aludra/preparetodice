<?php

namespace App\Entity;

use App\Repository\AttributeAlterationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttributeAlterationRepository::class)
 */
class AttributeAlteration extends Entity
{

    public function __toString()
    {
        $value = $this->getValue();
        switch($this->getCalculationType()) {
            case "percent_max":
                $value = $value . "% (max value)";
                break;
            case "percent_current":
                $value = $value . "% (current value)";
                break;
        }
        if($this->getIsNegative()) {
            $value = "-" . $value;
        } else {
            $value = "+" . $value;
        }
        return $value . " " . $this->getAttribute()->getAbreviation();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=StatusEffect::class, inversedBy="attributeAlterations")
     */
    private ?StatusEffect $statusEffect;

    /**
     * @ORM\ManyToOne(targetEntity=Attribute::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Attribute $attribute;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isNegative;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $calculationType;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $value;

    /**
     * @ORM\ManyToOne(targetEntity=Gear::class, inversedBy="attributeAlterations")
     */
    private $gear;

    /**
     * @ORM\ManyToOne(targetEntity=Passive::class, inversedBy="attributeAlterations")
     */
    private $passive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatusEffect(): ?StatusEffect
    {
        return $this->statusEffect;
    }

    public function setStatusEffect(?StatusEffect $statusEffect): self
    {
        $this->statusEffect = $statusEffect;

        return $this;
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

    public function getIsNegative(): ?bool
    {
        return $this->isNegative;
    }

    public function setIsNegative(bool $isNegative): self
    {
        $this->isNegative = $isNegative;

        return $this;
    }

    public function getCalculationType(): ?string
    {
        return $this->calculationType;
    }

    public function setCalculationType(string $calculationType): self
    {
        $this->calculationType = $calculationType;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getGear(): ?Gear
    {
        return $this->gear;
    }

    public function setGear(?Gear $gear): self
    {
        $this->gear = $gear;

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

    public function getSource()
    {
        if($this->getPassive() !== null)
            return "Passive " . $this->getPassive()->getName();
        elseif($this->getStatusEffect() !== null)
            return "Status effect " . $this->getStatusEffect()->getName();
        elseif($this->getGear() !== null)
            return "Gear " . $this->getGear()->getName();
        return "Unknown";
    }
}
