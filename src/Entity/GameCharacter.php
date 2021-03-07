<?php

namespace App\Entity;

use App\Repository\GameCharacterRepository;
use App\Service\CharacteristicsManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameCharacterRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class GameCharacter extends Entity
{

    const TEAM_ALLIES = "allies";
    const TEAM_FOES = "foes";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="gameCharacters")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Game $game;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\OneToMany(targetEntity=UserGameCharacter::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private Collection $userGameCharacters;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $description;

    /**
     * @ORM\OneToMany(targetEntity=CharacterResource::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private ?Collection $characterResources;

    /**
     * @ORM\OneToMany(targetEntity=CharacterAttribute::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private ?Collection $characterAttributes;

    /**
     * @ORM\OneToMany(targetEntity=CharacterSkill::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private ?Collection $characterSkills;

    /**
     * @ORM\OneToMany(targetEntity=CharacterPassive::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private ?Collection $characterPassives;

    /**
     * @ORM\OneToMany(targetEntity=InventoryWeapon::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private ?Collection $inventoryWeapons;

    /**
     * @ORM\OneToMany(targetEntity=InventoryConsumable::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private ?Collection $inventoryConsumables;

    /**
     * @ORM\OneToMany(targetEntity=InventoryGear::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private ?Collection $inventoryGears;

    /**
     * @ORM\OneToMany(targetEntity=InventoryItem::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private ?Collection $inventoryItems;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $team;

    /**
     * @ORM\OneToMany(targetEntity=Action::class, mappedBy="launcher")
     */
    private $actions;

    /**
     * @ORM\OneToMany(targetEntity=CharacterJob::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private $characterJobs;

    /**
     * @ORM\OneToMany(targetEntity=CharacterStatusEffect::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private $characterStatusEffects;

    /**
     * @ORM\ManyToOne(targetEntity=InventoryWeapon::class, inversedBy="gameCharacters")
     */
    private $equippedWeapon;

    /**
     * @ORM\OneToMany(targetEntity=EquippedGear::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private $equippedGears;

    /**
     * @ORM\OneToMany(targetEntity=CharacteristicCalculation::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private $characteristicCalculations;

    /**
     * @ORM\OneToMany(targetEntity=CharacterStory::class, mappedBy="gameCharacter", orphanRemoval=true)
     */
    private $characterStories;

    /**
     * @ORM\Column(type="integer")
     */
    private $Money;

    public function __construct()
    {
        $this->userGameCharacters = new ArrayCollection();
        $this->characterResources = new ArrayCollection();
        $this->characterAttributes = new ArrayCollection();
        $this->characterSkills = new ArrayCollection();
        $this->characterPassives = new ArrayCollection();
        $this->inventoryWeapons = new ArrayCollection();
        $this->inventoryConsumables = new ArrayCollection();
        $this->inventoryGears = new ArrayCollection();
        $this->inventoryItems = new ArrayCollection();
        $this->actions = new ArrayCollection();
        $this->characterJobs = new ArrayCollection();
        $this->characterStatusEffects = new ArrayCollection();
        $this->equippedGears = new ArrayCollection();
        $this->characteristicCalculations = new ArrayCollection();
        $this->characterStories = new ArrayCollection();
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

    /**
     * @return Collection|UserGameCharacter[]
     */
    public function getUserGameCharacters(): Collection
    {
        return $this->userGameCharacters;
    }

    public function addUserGameCharacter(UserGameCharacter $userGameCharacter): self
    {
        if (!$this->userGameCharacters->contains($userGameCharacter)) {
            $this->userGameCharacters[] = $userGameCharacter;
            $userGameCharacter->setGameCharacter($this);
        }

        return $this;
    }

    public function removeUserGameCharacter(UserGameCharacter $userGameCharacter): self
    {
        if ($this->userGameCharacters->contains($userGameCharacter)) {
            $this->userGameCharacters->removeElement($userGameCharacter);
            // set the owning side to null (unless already changed)
            if ($userGameCharacter->getGameCharacter() === $this) {
                $userGameCharacter->setGameCharacter(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|CharacterResource[]
     */
    public function getCharacterResources(): Collection
    {
        return $this->characterResources;
    }

    public function addCharacterResource(CharacterResource $characterResource): self
    {
        if (!$this->characterResources->contains($characterResource)) {
            $this->characterResources[] = $characterResource;
            $characterResource->setGameCharacter($this);
        }

        return $this;
    }

    public function removeCharacterResource(CharacterResource $characterResource): self
    {
        if ($this->characterResources->contains($characterResource)) {
            $this->characterResources->removeElement($characterResource);
            // set the owning side to null (unless already changed)
            if ($characterResource->getGameCharacter() === $this) {
                $characterResource->setGameCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CharacterAttribute[]
     */
    public function getCharacterAttributes(): Collection
    {
        return $this->characterAttributes;
    }

    public function addCharacterAttribute(CharacterAttribute $characterAttribute): self
    {
        if (!$this->characterAttributes->contains($characterAttribute)) {
            $this->characterAttributes[] = $characterAttribute;
            $characterAttribute->setGameCharacter($this);
        }

        return $this;
    }

    public function removeCharacterAttribute(CharacterAttribute $characterAttribute): self
    {
        if ($this->characterAttributes->contains($characterAttribute)) {
            $this->characterAttributes->removeElement($characterAttribute);
            // set the owning side to null (unless already changed)
            if ($characterAttribute->getGameCharacter() === $this) {
                $characterAttribute->setGameCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CharacterSkill[]
     */
    public function getCharacterSkills(): Collection
    {
        return $this->characterSkills;
    }

    public function addCharacterSkill(CharacterSkill $characterSkill): self
    {
        if (!$this->characterSkills->contains($characterSkill)) {
            $this->characterSkills[] = $characterSkill;
            $characterSkill->setGameCharacter($this);
        }

        return $this;
    }

    public function removeCharacterSkill(CharacterSkill $characterSkill): self
    {
        if ($this->characterSkills->contains($characterSkill)) {
            $this->characterSkills->removeElement($characterSkill);
            // set the owning side to null (unless already changed)
            if ($characterSkill->getGameCharacter() === $this) {
                $characterSkill->setGameCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CharacterPassive[]
     */
    public function getCharacterPassives(): Collection
    {
        return $this->characterPassives;
    }

    public function addCharacterPassive(CharacterPassive $characterPassife): self
    {
        if (!$this->characterPassives->contains($characterPassife)) {
            $this->characterPassives[] = $characterPassife;
            $characterPassife->setGameCharacter($this);
        }

        return $this;
    }

    public function removeCharacterPassive(CharacterPassive $characterPassife): self
    {
        if ($this->characterPassives->contains($characterPassife)) {
            $this->characterPassives->removeElement($characterPassife);
            // set the owning side to null (unless already changed)
            if ($characterPassife->getGameCharacter() === $this) {
                $characterPassife->setGameCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|InventoryWeapon[]
     */
    public function getInventoryWeapons(): Collection
    {
        return $this->inventoryWeapons;
    }

    public function addInventoryWeapon(InventoryWeapon $inventoryWeapon): self
    {
        if (!$this->inventoryWeapons->contains($inventoryWeapon)) {
            $this->inventoryWeapons[] = $inventoryWeapon;
            $inventoryWeapon->setGameCharacter($this);
        }

        return $this;
    }

    public function removeInventoryWeapon(InventoryWeapon $inventoryWeapon): self
    {
        if ($this->inventoryWeapons->contains($inventoryWeapon)) {
            $this->inventoryWeapons->removeElement($inventoryWeapon);
            // set the owning side to null (unless already changed)
            if ($inventoryWeapon->getGameCharacter() === $this) {
                $inventoryWeapon->setGameCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|InventoryConsumable[]
     */
    public function getInventoryConsumables(): Collection
    {
        return $this->inventoryConsumables;
    }

    public function addInventoryConsumable(InventoryConsumable $inventoryConsumable): self
    {
        if (!$this->inventoryConsumables->contains($inventoryConsumable)) {
            $this->inventoryConsumables[] = $inventoryConsumable;
            $inventoryConsumable->setGameCharacter($this);
        }

        return $this;
    }

    public function removeInventoryConsumable(InventoryConsumable $inventoryConsumable): self
    {
        if ($this->inventoryConsumables->contains($inventoryConsumable)) {
            $this->inventoryConsumables->removeElement($inventoryConsumable);
            // set the owning side to null (unless already changed)
            if ($inventoryConsumable->getGameCharacter() === $this) {
                $inventoryConsumable->setGameCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|InventoryGear[]
     */
    public function getInventoryGears(): Collection
    {
        return $this->inventoryGears;
    }

    public function addInventoryGear(InventoryGear $inventoryGear): self
    {
        if (!$this->inventoryGears->contains($inventoryGear)) {
            $this->inventoryGears[] = $inventoryGear;
            $inventoryGear->setGameCharacter($this);
        }

        return $this;
    }

    public function removeInventoryGear(InventoryGear $inventoryGear): self
    {
        if ($this->inventoryGears->contains($inventoryGear)) {
            $this->inventoryGears->removeElement($inventoryGear);
            // set the owning side to null (unless already changed)
            if ($inventoryGear->getGameCharacter() === $this) {
                $inventoryGear->setGameCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|InventoryItem[]
     */
    public function getInventoryItems(): Collection
    {
        return $this->inventoryItems;
    }

    public function addInventoryItem(InventoryItem $inventoryItem): self
    {
        if (!$this->inventoryItems->contains($inventoryItem)) {
            $this->inventoryItems[] = $inventoryItem;
            $inventoryItem->setGameCharacter($this);
        }

        return $this;
    }

    public function removeInventoryItem(InventoryItem $inventoryItem): self
    {
        if ($this->inventoryItems->contains($inventoryItem)) {
            $this->inventoryItems->removeElement($inventoryItem);
            // set the owning side to null (unless already changed)
            if ($inventoryItem->getGameCharacter() === $this) {
                $inventoryItem->setGameCharacter(null);
            }
        }

        return $this;
    }

    public function getTeam(): ?string
    {
        return $this->team;
    }

    public function setTeam(?string $team): self
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @param Resource $resource
     * @return CharacterResource|null
     */
    public function seekCharacterResource(Resource $resource)
    {
        /** @var CharacterResource $characterResource */
        foreach($this->getCharacterResources() as $characterResource) {
            if($characterResource->getResource()->getId() === $resource->getId())
                return $characterResource;
        }
        return null;
    }

    /**
     * @param Attribute $attribute
     * @return CharacterAttribute|null
     */
    public function seekCharacterAttribute(Attribute $attribute)
    {
        /** @var CharacterAttribute $characterAttribute */
        foreach($this->getCharacterAttributes() as $characterAttribute) {
            if($characterAttribute->getAttribute()->getId() === $attribute->getId())
                return $characterAttribute;
        }
        return null;
    }

    /**
     * @return Collection|Action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setLauncher($this);
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
            // set the owning side to null (unless already changed)
            if ($action->getLauncher() === $this) {
                $action->setLauncher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CharacterJob[]
     */
    public function getCharacterJobs(): Collection
    {
        return $this->characterJobs;
    }

    public function addCharacterJob(CharacterJob $characterJob): self
    {
        if (!$this->characterJobs->contains($characterJob)) {
            $this->characterJobs[] = $characterJob;
            $characterJob->setGameCharacter($this);
        }

        return $this;
    }

    public function removeCharacterJob(CharacterJob $characterJob): self
    {
        if ($this->characterJobs->contains($characterJob)) {
            $this->characterJobs->removeElement($characterJob);
            // set the owning side to null (unless already changed)
            if ($characterJob->getGameCharacter() === $this) {
                $characterJob->setGameCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CharacterStatusEffect[]
     */
    public function getCharacterStatusEffects(): Collection
    {
        return $this->characterStatusEffects;
    }

    public function addCharacterStatusEffect(CharacterStatusEffect $characterStatusEffect): self
    {
        if (!$this->characterStatusEffects->contains($characterStatusEffect)) {
            $this->characterStatusEffects[] = $characterStatusEffect;
            $characterStatusEffect->setGameCharacter($this);
        }

        return $this;
    }

    public function removeCharacterStatusEffect(CharacterStatusEffect $characterStatusEffect): self
    {
        if ($this->characterStatusEffects->contains($characterStatusEffect)) {
            $this->characterStatusEffects->removeElement($characterStatusEffect);
            // set the owning side to null (unless already changed)
            if ($characterStatusEffect->getGameCharacter() === $this) {
                $characterStatusEffect->setGameCharacter(null);
            }
        }

        return $this;
    }

    public function getEquippedWeapon(): ?InventoryWeapon
    {
        return $this->equippedWeapon;
    }

    public function setEquippedWeapon(?InventoryWeapon $equippedWeapon): self
    {
        $this->equippedWeapon = $equippedWeapon;

        return $this;
    }

    /**
     * @return Collection|EquippedGear[]
     */
    public function getEquippedGears(): Collection
    {
        return $this->equippedGears;
    }

    public function addEquippedGear(EquippedGear $equippedGear): self
    {
        if (!$this->equippedGears->contains($equippedGear)) {
            $this->equippedGears[] = $equippedGear;
            $equippedGear->setGameCharacter($this);
        }

        return $this;
    }

    public function removeEquippedGear(EquippedGear $equippedGear): self
    {
        if ($this->equippedGears->contains($equippedGear)) {
            $this->equippedGears->removeElement($equippedGear);
            // set the owning side to null (unless already changed)
            if ($equippedGear->getGameCharacter() === $this) {
                $equippedGear->setGameCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CharacteristicCalculation[]
     */
    public function getCharacteristicCalculations(): Collection
    {
        return $this->characteristicCalculations;
    }

    public function addCharacteristicCalculation(CharacteristicCalculation $characteristicCalculation): self
    {
        if (!$this->characteristicCalculations->contains($characteristicCalculation)) {
            $this->characteristicCalculations[] = $characteristicCalculation;
            $characteristicCalculation->setGameCharacter($this);
        }

        return $this;
    }

    public function removeCharacteristicCalculation(CharacteristicCalculation $characteristicCalculation): self
    {
        if ($this->characteristicCalculations->contains($characteristicCalculation)) {
            $this->characteristicCalculations->removeElement($characteristicCalculation);
            // set the owning side to null (unless already changed)
            if ($characteristicCalculation->getGameCharacter() === $this) {
                $characteristicCalculation->setGameCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @param DamageNature $damageNature
     * @return int
     */
    public function getDamageNatureDefense(DamageNature $damageNature) :int
    {
        $defense = 0;
        foreach($this->getCharacterAttributes() as $characterAttribute) {
            if($characterAttribute->getFinalValue() > 0) {
                foreach($characterAttribute->getAttribute()->getDefenses() as $defense) {
                    $defense = round($defense + ($defense->getEfficiency() * $characterAttribute->getFinalValue()));
                }
            }
        }
        if($defense > 100)
            $defense = 100;
        return $defense;
    }

    /**
     * @return Collection|CharacterStory[]
     */
    public function getCharacterStories(): Collection
    {
        return $this->characterStories;
    }

    public function addCharacterStory(CharacterStory $characterStory): self
    {
        if (!$this->characterStories->contains($characterStory)) {
            $this->characterStories[] = $characterStory;
            $characterStory->setGameCharacter($this);
        }

        return $this;
    }

    public function removeCharacterStory(CharacterStory $characterStory): self
    {
        if ($this->characterStories->contains($characterStory)) {
            $this->characterStories->removeElement($characterStory);
            // set the owning side to null (unless already changed)
            if ($characterStory->getGameCharacter() === $this) {
                $characterStory->setGameCharacter(null);
            }
        }

        return $this;
    }

    public function getMoney(): ?int
    {
        return $this->Money;
    }

    public function setMoney(int $Money): self
    {
        $this->Money = $Money;

        return $this;
    }

}
