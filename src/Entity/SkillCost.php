<?php

namespace App\Entity;

use App\Repository\SkillCostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SkillCostRepository::class)
 */
class SkillCost extends Entity
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
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="skillCosts")
     */
    private ?Skill $skill;

    /**
     * @ORM\ManyToOne(targetEntity=Resource::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Resource $resource;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private ?string $calculationType;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $value;

    /**
     * @ORM\ManyToOne(targetEntity=Weapon::class, inversedBy="skillCosts")
     */
    private ?Weapon $weapon;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="skillCosts")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?Action $action;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

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

    public function setCalculationType(?string $calculationType): self
    {
        $this->calculationType = $calculationType;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    public function setWeapon(?Weapon $weapon): self
    {
        $this->weapon = $weapon;

        return $this;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(?Action $action): self
    {
        $this->action = $action;

        return $this;
    }
}
