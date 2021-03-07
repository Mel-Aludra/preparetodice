<?php

namespace App\Entity;

use App\Repository\TargetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TargetRepository::class)
 */
class Target
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=GameCharacter::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?GameCharacter $gameCharacter;

    /**
     * @ORM\ManyToOne(targetEntity=SkillHealEffect::class, inversedBy="targets")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?SkillHealEffect $skillHealEffect;

    /**
     * @ORM\ManyToOne(targetEntity=SkillDamageEffect::class, inversedBy="targets")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?SkillDamageEffect $skillDamageEffect;

    /**
     * @ORM\ManyToOne(targetEntity=SkillStatusEffect::class, inversedBy="targets")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private ?SkillStatusEffect $skillStatusEffect;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameCharacter(): ?GameCharacter
    {
        return $this->gameCharacter;
    }

    public function setGameCharacter(?GameCharacter $gameCharacter): self
    {
        $this->gameCharacter = $gameCharacter;

        return $this;
    }

    public function getSkillHealEffect(): ?SkillHealEffect
    {
        return $this->skillHealEffect;
    }

    public function setSkillHealEffect(?SkillHealEffect $skillHealEffect): self
    {
        $this->skillHealEffect = $skillHealEffect;

        return $this;
    }

    public function getSkillDamageEffect(): ?SkillDamageEffect
    {
        return $this->skillDamageEffect;
    }

    public function setSkillDamageEffect(?SkillDamageEffect $skillDamageEffect): self
    {
        $this->skillDamageEffect = $skillDamageEffect;

        return $this;
    }

    public function getSkillStatusEffect(): ?SkillStatusEffect
    {
        return $this->skillStatusEffect;
    }

    public function setSkillStatusEffect(?SkillStatusEffect $skillStatusEffect): self
    {
        $this->skillStatusEffect = $skillStatusEffect;

        return $this;
    }
}
