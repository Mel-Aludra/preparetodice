<?php

namespace App\Entity;

use App\Repository\CharacterSkillRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacterSkillRepository::class)
 */
class CharacterSkill extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=GameCharacter::class, inversedBy="characterSkills")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?GameCHaracter $gameCharacter;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="characterSkills")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private ?Skill $skill;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $currentCooldown;

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

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    public function getCurrentCooldown(): ?int
    {
        return $this->currentCooldown;
    }

    public function setCurrentCooldown(?int $currentCooldown): self
    {
        $this->currentCooldown = $currentCooldown;

        return $this;
    }

    /**
     * @return array
     */
    public function launchRestrictions() :array
    {
        //Restrictions
        $restrictions = [];
        $gameCharacter = $this->getGameCharacter();

        //CD
        if($this->getCurrentCooldown() > 0) {
            $restrictions[] = "CD";
        }

        //Resources needed amounts
        $resourcesNeeded = [];
        foreach($this->getSkill()->getSkillCosts() as $skillCost) {

            //Get character resource
            $charResource = $gameCharacter->seekCharacterResource($skillCost->getResource());
            if($charResource === null)
                $restrictions[] = $skillCost->getResource()->getName() . " is needed";
            else {

                //Add resource to needed elements
                if(!isset($resourcesNeeded[$skillCost->getResource()->getId()])) {
                    $resourcesNeeded[$skillCost->getResource()->getId()] = [
                        "Resource" => $skillCost->getResource(),
                        "Costs" => []
                    ];
                }

                //Calculate amount
                switch($skillCost->getCalculationType()) {

                    case "points":
                        $resourcesNeeded[$skillCost->getResource()->getId()]["Costs"][] = $skillCost->getValue();
                        break;

                    case "percent_max":
                        $resourcesNeeded[$skillCost->getResource()->getId()]["Costs"][] = round($skillCost->getValue() * $charResource->getFinalValue() / 100);
                        break;

                }
            }

        }

        foreach($resourcesNeeded as $resourceNeeded) {

            //Total amount
            $required = 0;
            foreach($resourceNeeded["Costs"] as $amount) {
                $required = $amount;
            }

            //Looking for resource
            $charResource = $gameCharacter->seekCharacterResource($resourceNeeded["Resource"]);

            //Check
            $projection = $charResource->getCurrentValue();
            $projection = $projection - $required;
            if($projection < 0) {
                $restrictions[] = $charResource->getResource()->getAbreviation();
            }

        }

        //Return restrictions
        return $restrictions;

    }
}
