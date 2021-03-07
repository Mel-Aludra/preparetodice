<?php

namespace App\Entity;

use App\Repository\DamageOverTimeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DamageOverTimeRepository::class)
 */
class DamageOverTime extends Entity
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
        return $value . " " . $this->getResource()->getAbreviation();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=StatusEffect::class, inversedBy="damageOverTimes")
     */
    private ?StatusEffect $statusEffect;

    /**
     * @ORM\ManyToOne(targetEntity=DamageNature::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?DamageNature $damageNature;

    /**
     * @ORM\ManyToOne(targetEntity=Resource::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Resource $resource;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $calculationType;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $value;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $ignoreDefense;

    /**
     * @ORM\ManyToOne(targetEntity=Gear::class, inversedBy="damageOverTimes")
     */
    private $gear;

    /**
     * @ORM\ManyToOne(targetEntity=Passive::class, inversedBy="damageOverTimes")
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

    public function getDamageNature(): ?DamageNature
    {
        return $this->damageNature;
    }

    public function setDamageNature(?DamageNature $damageNature): self
    {
        $this->damageNature = $damageNature;

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

    public function getIgnoreDefense(): ?bool
    {
        return $this->ignoreDefense;
    }

    public function setIgnoreDefense(bool $ignoreDefense): self
    {
        $this->ignoreDefense = $ignoreDefense;

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
}
