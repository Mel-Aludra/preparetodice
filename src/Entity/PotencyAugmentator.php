<?php

namespace App\Entity;

use App\Repository\PotencyAugmentatorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PotencyAugmentatorRepository::class)
 */
class PotencyAugmentator
{

    const TYPE_ADD = "add";
    const TYPE_ADD_SOOTHE = "add_soothe";
    const TYPE_ADD_DIVIDED_TEN = "add_divided_ten";
    const TYPE_MULTIPLY = "multiply";
    const TYPE_MULTIPLY_SOOTHE = "multiply_soothe";

    const TYPES_CHOICE = [
        "Adds the attribute of the caster to the effect potency." => self::TYPE_ADD,
        "Adds the attribute of the caster divided by 3 to the effect potency." => self::TYPE_ADD_SOOTHE,
        "Adds the attribute of the caster divided by 10 to the effect potency." => self::TYPE_ADD_DIVIDED_TEN,
        "Modifies the effect potency by multiplying it by the attribute of the caster. Cannot go below base potency." => self::TYPE_MULTIPLY,
        "Modifies the effect potency by multiplying it by the attribute of the caster divided by 3. Cannot go below base potency." => self::TYPE_MULTIPLY_SOOTHE
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $type;

    /**
     * @ORM\ManyToOne(targetEntity=Attribute::class, inversedBy="potencyAugmentators")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Attribute $attribute;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $percentCeiling;

    /**
     * @ORM\ManyToMany(targetEntity=SkillHealEffect::class, mappedBy="potencyAugmentator")
     */
    private ?Collection $skillHealEffects;

    /**
     * @ORM\ManyToMany(targetEntity=SkillDamageEffect::class, mappedBy="potencyAugmentator")
     */
    private ?Collection $skillDamageEffects;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="potencyAugmentators")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Game $game;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->skillHealEffects = new ArrayCollection();
        $this->skillDamageEffects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getPercentCeiling(): ?int
    {
        return $this->percentCeiling;
    }

    public function setPercentCeiling(?int $percentCeiling): self
    {
        $this->percentCeiling = $percentCeiling;

        return $this;
    }

    /**
     * @return Collection|SkillHealEffect[]
     */
    public function getSkillHealEffects(): Collection
    {
        return $this->skillHealEffects;
    }

    public function addSkillHealEffect(SkillHealEffect $skillHealEffect): self
    {
        if (!$this->skillHealEffects->contains($skillHealEffect)) {
            $this->skillHealEffects[] = $skillHealEffect;
            $skillHealEffect->addPotencyAugmentator($this);
        }

        return $this;
    }

    public function removeSkillHealEffect(SkillHealEffect $skillHealEffect): self
    {
        if ($this->skillHealEffects->contains($skillHealEffect)) {
            $this->skillHealEffects->removeElement($skillHealEffect);
            $skillHealEffect->removePotencyAugmentator($this);
        }

        return $this;
    }

    /**
     * @return Collection|SkillDamageEffect[]
     */
    public function getSkillDamageEffects(): Collection
    {
        return $this->skillDamageEffects;
    }

    public function addSkillDamageEffect(SkillDamageEffect $skillDamageEffect): self
    {
        if (!$this->skillDamageEffects->contains($skillDamageEffect)) {
            $this->skillDamageEffects[] = $skillDamageEffect;
            $skillDamageEffect->addPotencyAugmentator($this);
        }

        return $this;
    }

    public function removeSkillDamageEffect(SkillDamageEffect $skillDamageEffect): self
    {
        if ($this->skillDamageEffects->contains($skillDamageEffect)) {
            $this->skillDamageEffects->removeElement($skillDamageEffect);
            $skillDamageEffect->removePotencyAugmentator($this);
        }

        return $this;
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

    /**
     * @return string|null
     */
    public function getTypeDescription() :?string
    {
        foreach(self::TYPES_CHOICE as $description => $type) {
            if($type === $this->getType())
                return $description;
        }
        return null;
    }
}
