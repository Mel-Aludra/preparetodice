<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game extends Entity
{

    const BACKGROUNDS = [
        "Default (neutral abstract image)" => "img_neutral",
        "Forest" => "img_forest",
        "Modern city" => "img_modernLandscape",
        "Flashing space" => "img_flashingSpace",
        "Cosmos" => "img_cosmos",
        "Night lake" => "img_nightLake"
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @Assert\NotBlank(message="Game's name can't be empty.")
     * @Assert\Length(min=3, max=255, minMessage="Name's length can't be lesser than 3 characters.", maxMessage="Name's length can't be greater than 255 characters.")
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @Assert\NotBlank(message="Game's description can't be empty.")
     * @Assert\Length(min=3, max=255, minMessage="Description's length can't be lesser than 3 characters.", maxMessage="Description's length can't be greater than 255 characters.")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\OneToMany(targetEntity=UserGame::class, mappedBy="game", orphanRemoval=true)
     */
    private Collection $userGames;

    /**
     * @ORM\OneToMany(targetEntity=GameCharacter::class, mappedBy="game", orphanRemoval=true)
     */
    private Collection $gameCharacters;

    /**
     * @ORM\OneToMany(targetEntity=LoreTag::class, mappedBy="game", orphanRemoval=true)
     */
    private Collection $loreTags;

    /**
     * @ORM\OneToMany(targetEntity=LoreBlock::class, mappedBy="game", orphanRemoval=true)
     */
    private Collection $loreBlocks;

    /**
     * @ORM\OneToMany(targetEntity=Resource::class, mappedBy="game", orphanRemoval=true)
     */
    private Collection $resources;

    /**
     * @ORM\OneToMany(targetEntity=Attribute::class, mappedBy="game", orphanRemoval=true)
     */
    private Collection $attributes;

    /**
     * @ORM\OneToMany(targetEntity=DamageNature::class, mappedBy="game", orphanRemoval=true)
     */
    private Collection $damageNatures;

    /**
     * @ORM\OneToMany(targetEntity=Skill::class, mappedBy="game", orphanRemoval=true)
     */
    private ?Collection $skills;

    /**
     * @ORM\OneToMany(targetEntity=StatusEffect::class, mappedBy="game", orphanRemoval=true)
     */
    private ?Collection $statusEffects;

    /**
     * @ORM\OneToMany(targetEntity=Weapon::class, mappedBy="game", orphanRemoval=true)
     */
    private ?Collection $weapons;

    /**
     * @ORM\OneToMany(targetEntity=Item::class, mappedBy="game", orphanRemoval=true)
     */
    private ?Collection $items;

    /**
     * @ORM\OneToMany(targetEntity=Gear::class, mappedBy="game", orphanRemoval=true)
     */
    private ?Collection $gears;

    /**
     * @ORM\OneToMany(targetEntity=Consumable::class, mappedBy="game", orphanRemoval=true)
     */
    private ?Collection $consumables;

    /**
     * @ORM\OneToMany(targetEntity=Passive::class, mappedBy="game", orphanRemoval=true)
     */
    private ?Collection $passives;

    /**
     * @ORM\OneToMany(targetEntity=Battle::class, mappedBy="game", orphanRemoval=true)
     */
    private ?Collection $battles;

    /**
     * @ORM\OneToOne(targetEntity=Battle::class, cascade={"persist", "remove"})
     */
    private ?Battle $currentBattle;

    /**
     * @ORM\ManyToOne(targetEntity=Resource::class)
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private ?Resource $lifeResource;

    /**
     * @ORM\ManyToOne(targetEntity=Resource::class)
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private ?Resource $actionPointsResource;

    /**
     * @ORM\OneToMany(targetEntity=PotencyAugmentator::class, mappedBy="game", orphanRemoval=true)
     */
    private $potencyAugmentators;

    /**
     * @ORM\OneToMany(targetEntity=Job::class, mappedBy="game", orphanRemoval=true)
     */
    private $jobs;

    /**
     * @ORM\OneToMany(targetEntity=EquipmentSlot::class, mappedBy="game", orphanRemoval=true)
     */
    private $equipmentSlots;

    /**
     * @ORM\OneToMany(targetEntity=Invitation::class, mappedBy="game", orphanRemoval=true)
     */
    private $invitations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $background;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $moneyTerm;

    public function __construct()
    {
        $this->userGames = new ArrayCollection();
        $this->gameCharacters = new ArrayCollection();
        $this->loreTags = new ArrayCollection();
        $this->loreBlocks = new ArrayCollection();
        $this->resources = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->damageNatures = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->statusEffects = new ArrayCollection();
        $this->weapons = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->gears = new ArrayCollection();
        $this->consumables = new ArrayCollection();
        $this->passives = new ArrayCollection();
        $this->battles = new ArrayCollection();
        $this->potencyAugmentators = new ArrayCollection();
        $this->jobs = new ArrayCollection();
        $this->equipmentSlots = new ArrayCollection();
        $this->invitations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|UserGame[]
     */
    public function getUserGames(): Collection
    {
        return $this->userGames;
    }

    public function addUserGame(UserGame $userGame): self
    {
        if (!$this->userGames->contains($userGame)) {
            $this->userGames[] = $userGame;
            $userGame->setGame($this);
        }

        return $this;
    }

    public function removeUserGame(UserGame $userGame): self
    {
        if ($this->userGames->contains($userGame)) {
            $this->userGames->removeElement($userGame);
            // set the owning side to null (unless already changed)
            if ($userGame->getGame() === $this) {
                $userGame->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GameCharacter[]
     */
    public function getGameCharacters(): Collection
    {
        return $this->gameCharacters;
    }

    public function addGameCharacter(GameCharacter $gameCharacter): self
    {
        if (!$this->gameCharacters->contains($gameCharacter)) {
            $this->gameCharacters[] = $gameCharacter;
            $gameCharacter->setGame($this);
        }

        return $this;
    }

    public function removeGameCharacter(GameCharacter $gameCharacter): self
    {
        if ($this->gameCharacters->contains($gameCharacter)) {
            $this->gameCharacters->removeElement($gameCharacter);
            // set the owning side to null (unless already changed)
            if ($gameCharacter->getGame() === $this) {
                $gameCharacter->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LoreTag[]
     */
    public function getLoreTags(): Collection
    {
        return $this->loreTags;
    }

    public function addLoreTag(LoreTag $loreTag): self
    {
        if (!$this->loreTags->contains($loreTag)) {
            $this->loreTags[] = $loreTag;
            $loreTag->setGame($this);
        }

        return $this;
    }

    public function removeLoreTag(LoreTag $loreTag): self
    {
        if ($this->loreTags->contains($loreTag)) {
            $this->loreTags->removeElement($loreTag);
            // set the owning side to null (unless already changed)
            if ($loreTag->getGame() === $this) {
                $loreTag->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LoreBlock[]
     */
    public function getLoreBlocks(): Collection
    {
        return $this->loreBlocks;
    }

    public function addLoreBlock(LoreBlock $loreBlock): self
    {
        if (!$this->loreBlocks->contains($loreBlock)) {
            $this->loreBlocks[] = $loreBlock;
            $loreBlock->setGame($this);
        }

        return $this;
    }

    public function removeLoreBlock(LoreBlock $loreBlock): self
    {
        if ($this->loreBlocks->contains($loreBlock)) {
            $this->loreBlocks->removeElement($loreBlock);
            // set the owning side to null (unless already changed)
            if ($loreBlock->getGame() === $this) {
                $loreBlock->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Resource[]
     */
    public function getResources(): Collection
    {
        return $this->resources;
    }

    public function addResource(Resource $resource): self
    {
        if (!$this->resources->contains($resource)) {
            $this->resources[] = $resource;
            $resource->setGame($this);
        }

        return $this;
    }

    public function removeResource(Resource $resource): self
    {
        if ($this->resources->contains($resource)) {
            $this->resources->removeElement($resource);
            // set the owning side to null (unless already changed)
            if ($resource->getGame() === $this) {
                $resource->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Attribute[]
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function addAttribute(Attribute $attribute): self
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes[] = $attribute;
            $attribute->setGame($this);
        }

        return $this;
    }

    public function removeAttribute(Attribute $attribute): self
    {
        if ($this->attributes->contains($attribute)) {
            $this->attributes->removeElement($attribute);
            // set the owning side to null (unless already changed)
            if ($attribute->getGame() === $this) {
                $attribute->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DamageNature[]
     */
    public function getDamageNatures(): Collection
    {
        return $this->damageNatures;
    }

    public function addDamageNature(DamageNature $damageNature): self
    {
        if (!$this->damageNatures->contains($damageNature)) {
            $this->damageNatures[] = $damageNature;
            $damageNature->setGame($this);
        }

        return $this;
    }

    public function removeDamageNature(DamageNature $damageNature): self
    {
        if ($this->damageNatures->contains($damageNature)) {
            $this->damageNatures->removeElement($damageNature);
            // set the owning side to null (unless already changed)
            if ($damageNature->getGame() === $this) {
                $damageNature->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setGame($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
            // set the owning side to null (unless already changed)
            if ($skill->getGame() === $this) {
                $skill->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StatusEffect[]
     */
    public function getStatusEffects(): Collection
    {
        return $this->statusEffects;
    }

    public function addStatusEffect(StatusEffect $statusEffect): self
    {
        if (!$this->statusEffects->contains($statusEffect)) {
            $this->statusEffects[] = $statusEffect;
            $statusEffect->setGame($this);
        }

        return $this;
    }

    public function removeStatusEffect(StatusEffect $statusEffect): self
    {
        if ($this->statusEffects->contains($statusEffect)) {
            $this->statusEffects->removeElement($statusEffect);
            // set the owning side to null (unless already changed)
            if ($statusEffect->getGame() === $this) {
                $statusEffect->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Weapon[]
     */
    public function getWeapons(): Collection
    {
        return $this->weapons;
    }

    public function addWeapon(Weapon $weapon): self
    {
        if (!$this->weapons->contains($weapon)) {
            $this->weapons[] = $weapon;
            $weapon->setGame($this);
        }

        return $this;
    }

    public function removeWeapon(Weapon $weapon): self
    {
        if ($this->weapons->contains($weapon)) {
            $this->weapons->removeElement($weapon);
            // set the owning side to null (unless already changed)
            if ($weapon->getGame() === $this) {
                $weapon->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setGame($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getGame() === $this) {
                $item->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Gear[]
     */
    public function getGears(): Collection
    {
        return $this->gears;
    }

    public function addGear(Gear $gear): self
    {
        if (!$this->gears->contains($gear)) {
            $this->gears[] = $gear;
            $gear->setGame($this);
        }

        return $this;
    }

    public function removeGear(Gear $gear): self
    {
        if ($this->gears->contains($gear)) {
            $this->gears->removeElement($gear);
            // set the owning side to null (unless already changed)
            if ($gear->getGame() === $this) {
                $gear->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Consumable[]
     */
    public function getConsumables(): Collection
    {
        return $this->consumables;
    }

    public function addConsumable(Consumable $consumable): self
    {
        if (!$this->consumables->contains($consumable)) {
            $this->consumables[] = $consumable;
            $consumable->setGame($this);
        }

        return $this;
    }

    public function removeConsumable(Consumable $consumable): self
    {
        if ($this->consumables->contains($consumable)) {
            $this->consumables->removeElement($consumable);
            // set the owning side to null (unless already changed)
            if ($consumable->getGame() === $this) {
                $consumable->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Passive[]
     */
    public function getPassives(): Collection
    {
        return $this->passives;
    }

    public function addPassive(Passive $passive): self
    {
        if (!$this->passives->contains($passive)) {
            $this->passives[] = $passive;
            $passive->setGame($this);
        }

        return $this;
    }

    public function removePassive(Passive $passive): self
    {
        if ($this->passives->contains($passive)) {
            $this->passives->removeElement($passive);
            // set the owning side to null (unless already changed)
            if ($passive->getGame() === $this) {
                $passive->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Battle[]
     */
    public function getBattles(): Collection
    {
        return $this->battles;
    }

    public function addBattle(Battle $battle): self
    {
        if (!$this->battles->contains($battle)) {
            $this->battles[] = $battle;
            $battle->setGame($this);
        }

        return $this;
    }

    public function removeBattle(Battle $battle): self
    {
        if ($this->battles->contains($battle)) {
            $this->battles->removeElement($battle);
            // set the owning side to null (unless already changed)
            if ($battle->getGame() === $this) {
                $battle->setGame(null);
            }
        }

        return $this;
    }

    public function getCurrentBattle(): ?Battle
    {
        return $this->currentBattle;
    }

    public function setCurrentBattle(?Battle $currentBattle): self
    {
        $this->currentBattle = $currentBattle;

        return $this;
    }

    public function getLifeResource(): ?Resource
    {
        return $this->lifeResource;
    }

    public function setLifeResource(?Resource $lifeResource): self
    {
        $this->lifeResource = $lifeResource;

        return $this;
    }

    public function getActionPointsResource(): ?Resource
    {
        return $this->actionPointsResource;
    }

    public function setActionPointsResource(?Resource $actionPointsResource): self
    {
        $this->actionPointsResource = $actionPointsResource;

        return $this;
    }

    /**
     * @return Collection|PotencyAugmentator[]
     */
    public function getPotencyAugmentators(): Collection
    {
        return $this->potencyAugmentators;
    }

    public function addPotencyAugmentator(PotencyAugmentator $potencyAugmentator): self
    {
        if (!$this->potencyAugmentators->contains($potencyAugmentator)) {
            $this->potencyAugmentators[] = $potencyAugmentator;
            $potencyAugmentator->setGame($this);
        }

        return $this;
    }

    public function removePotencyAugmentator(PotencyAugmentator $potencyAugmentator): self
    {
        if ($this->potencyAugmentators->contains($potencyAugmentator)) {
            $this->potencyAugmentators->removeElement($potencyAugmentator);
            // set the owning side to null (unless already changed)
            if ($potencyAugmentator->getGame() === $this) {
                $potencyAugmentator->setGame(null);
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
            $job->setGame($this);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
            // set the owning side to null (unless already changed)
            if ($job->getGame() === $this) {
                $job->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EquipmentSlot[]
     */
    public function getEquipmentSlots(): Collection
    {
        return $this->equipmentSlots;
    }

    public function addEquipmentSlot(EquipmentSlot $equipmentSlot): self
    {
        if (!$this->equipmentSlots->contains($equipmentSlot)) {
            $this->equipmentSlots[] = $equipmentSlot;
            $equipmentSlot->setGame($this);
        }

        return $this;
    }

    public function removeEquipmentSlot(EquipmentSlot $equipmentSlot): self
    {
        if ($this->equipmentSlots->contains($equipmentSlot)) {
            $this->equipmentSlots->removeElement($equipmentSlot);
            // set the owning side to null (unless already changed)
            if ($equipmentSlot->getGame() === $this) {
                $equipmentSlot->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @param $id
     * @return EquipmentSlot|null
     */
    public function getEquipmentSlotFromId($id) :?EquipmentSlot
    {
        foreach($this->getEquipmentSlots() as $equipmentSlot) {
            if((int) $id === (int) $equipmentSlot->getId())
                return $equipmentSlot;
        }
        return null;
    }

    /**
     * @return Collection|Invitation[]
     */
    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(Invitation $invitation): self
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations[] = $invitation;
            $invitation->setGame($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): self
    {
        if ($this->invitations->contains($invitation)) {
            $this->invitations->removeElement($invitation);
            // set the owning side to null (unless already changed)
            if ($invitation->getGame() === $this) {
                $invitation->setGame(null);
            }
        }

        return $this;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(?string $background): self
    {
        $this->background = $background;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getMoneyTerm(): ?string
    {
        return $this->moneyTerm;
    }

    public function setMoneyTerm(string $moneyTerm): self
    {
        $this->moneyTerm = $moneyTerm;

        return $this;
    }

}
