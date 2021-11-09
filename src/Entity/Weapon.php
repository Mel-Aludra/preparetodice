<?php

namespace App\Entity;

use App\Repository\WeaponRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeaponRepository::class)
 */
class Weapon extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="weapons")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Game $game;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\OneToMany(targetEntity=SkillHealEffect::class, mappedBy="weapon", orphanRemoval=true)
     */
    private ?Collection $skillHealEffects;

    /**
     * @ORM\OneToMany(targetEntity=SkillDamageEffect::class, mappedBy="weapon", orphanRemoval=true)
     */
    private ?Collection $skillDamageEffects;

    /**
     * @ORM\OneToMany(targetEntity=SkillCost::class, mappedBy="weapon", orphanRemoval=true)
     */
    private ?Collection $skillCosts;

    /**
     * @ORM\OneToMany(targetEntity=SkillGain::class, mappedBy="weapon", orphanRemoval=true)
     */
    private ?Collection $skillGains;

    /**
     * @ORM\OneToMany(targetEntity=SkillStatusEffect::class, mappedBy="weapon", orphanRemoval=true)
     */
    private $skillStatusEffects;

    /**
     * @ORM\ManyToMany(targetEntity=Job::class, inversedBy="weapons")
     */
    private $jobs;

    public function __construct()
    {
        $this->skillHealEffects = new ArrayCollection();
        $this->skillDamageEffects = new ArrayCollection();
        $this->skillCosts = new ArrayCollection();
        $this->skillGains = new ArrayCollection();
        $this->skillStatusEffects = new ArrayCollection();
        $this->jobs = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $skillHealEffect->setWeapon($this);
        }

        return $this;
    }

    public function removeSkillHealEffect(SkillHealEffect $skillHealEffect): self
    {
        if ($this->skillHealEffects->contains($skillHealEffect)) {
            $this->skillHealEffects->removeElement($skillHealEffect);
            // set the owning side to null (unless already changed)
            if ($skillHealEffect->getWeapon() === $this) {
                $skillHealEffect->setWeapon(null);
            }
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
            $skillDamageEffect->setWeapon($this);
        }

        return $this;
    }

    public function removeSkillDamageEffect(SkillDamageEffect $skillDamageEffect): self
    {
        if ($this->skillDamageEffects->contains($skillDamageEffect)) {
            $this->skillDamageEffects->removeElement($skillDamageEffect);
            // set the owning side to null (unless already changed)
            if ($skillDamageEffect->getWeapon() === $this) {
                $skillDamageEffect->setWeapon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SkillCost[]
     */
    public function getSkillCosts(): Collection
    {
        return $this->skillCosts;
    }

    public function addSkillCost(SkillCost $skillCost): self
    {
        if (!$this->skillCosts->contains($skillCost)) {
            $this->skillCosts[] = $skillCost;
            $skillCost->setWeapon($this);
        }

        return $this;
    }

    public function removeSkillCost(SkillCost $skillCost): self
    {
        if ($this->skillCosts->contains($skillCost)) {
            $this->skillCosts->removeElement($skillCost);
            // set the owning side to null (unless already changed)
            if ($skillCost->getWeapon() === $this) {
                $skillCost->setWeapon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SkillGain[]
     */
    public function getSkillGains(): Collection
    {
        return $this->skillGains;
    }

    public function addSkillGain(SkillGain $skillGain): self
    {
        if (!$this->skillGains->contains($skillGain)) {
            $this->skillGains[] = $skillGain;
            $skillGain->setWeapon($this);
        }

        return $this;
    }

    public function removeSkillGain(SkillGain $skillGain): self
    {
        if ($this->skillGains->contains($skillGain)) {
            $this->skillGains->removeElement($skillGain);
            // set the owning side to null (unless already changed)
            if ($skillGain->getWeapon() === $this) {
                $skillGain->setWeapon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SkillStatusEffect[]
     */
    public function getSkillStatusEffects(): Collection
    {
        return $this->skillStatusEffects;
    }

    public function addSkillStatusEffect(SkillStatusEffect $skillStatusEffect): self
    {
        if (!$this->skillStatusEffects->contains($skillStatusEffect)) {
            $this->skillStatusEffects[] = $skillStatusEffect;
            $skillStatusEffect->setWeapon($this);
        }

        return $this;
    }

    public function removeSkillStatusEffect(SkillStatusEffect $skillStatusEffect): self
    {
        if ($this->skillStatusEffects->contains($skillStatusEffect)) {
            $this->skillStatusEffects->removeElement($skillStatusEffect);
            // set the owning side to null (unless already changed)
            if ($skillStatusEffect->getWeapon() === $this) {
                $skillStatusEffect->setWeapon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Job[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs[] = $job;
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasEffect() :bool
    {
        $effects = count($this->getSkillHealEffects()) + count($this->getSkillDamageEffects()) + count($this->getSkillStatusEffects());
        if($effects > 0) {
            return true;
        }
        return false;
    }
}
