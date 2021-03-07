<?php

namespace App\Service;

use App\Entity\Attribute;
use App\Entity\DamageNature;
use App\Entity\Defense;
use App\Entity\EquipmentSlot;
use App\Entity\Game;
use App\Entity\PotencyAugmentator;
use App\Entity\Resource;
use App\Repository\ColorRepository;
use Doctrine\ORM\EntityManagerInterface;

class HydrateGameService
{

    private EntityManagerInterface $manager;
    private ColorRepository $colorsRepo;

    public function __construct(EntityManagerInterface $manager, ColorRepository $colorsRepo)
    {
        $this->manager = $manager;
        $this->colorsRepo = $colorsRepo;
    }

    public function basicGameHydratation(Game $game)
    {

        //Damage natures

        $physicalNature = new DamageNature();
        $physicalNature->setName("Physical")
            ->setAbreviation("PHY")
            ->setGame($game);
        $game->addDamageNature($physicalNature);
        $this->manager->persist($physicalNature);

        $magicalNature = new DamageNature();
        $magicalNature->setName("Magical")
            ->setAbreviation("MAG")
            ->setGame($game);
        $game->addDamageNature($magicalNature);
        $this->manager->persist($magicalNature);

        //Attributes

        $strength = new Attribute();
        $strength->setGame($game)
            ->setName("Strength")
            ->setAbreviation("STR")
            ->setDescription("This attribute is use for physical abilities.")
            ->setMaximumValue(99)
            ->setColor($this->colorsRepo->findOneBy(["name" => "Red"]));
        $game->addAttribute($strength);
        $this->manager->persist($strength);
        $defense = new Defense();
        $defense->setAttribute($strength)
            ->setDamageNature($physicalNature)
            ->setEfficiency(30);
        $strength->addDefense($defense);
        $this->manager->persist($defense);

        $intel = new Attribute();
        $intel->setGame($game)
            ->setName("Intelligence")
            ->setAbreviation("INT")
            ->setDescription("This attribute is use for magical abilities.")
            ->setMaximumValue(99)
            ->setColor($this->colorsRepo->findOneBy(["name" => "Blue"]));
        $game->addAttribute($intel);
        $this->manager->persist($intel);
        $defense = new Defense();
        $defense->setAttribute($intel)
            ->setDamageNature($magicalNature)
            ->setEfficiency(30);
        $intel->addDefense($defense);
        $this->manager->persist($defense);

        $dexterity = new Attribute();
        $dexterity->setGame($game)
            ->setName("Dexterity")
            ->setAbreviation("DEX")
            ->setDescription("This attribute is use for ability.")
            ->setMaximumValue(99)
            ->setColor($this->colorsRepo->findOneBy(["name" => "Purple"]));
        $game->addAttribute($dexterity);
        $this->manager->persist($dexterity);

        //Resources

        $life = new Resource();
        $life->setGame($game)
            ->setName("Health points")
            ->setAbreviation("HP")
            ->setDescription("Represents your life.")
            ->setColor($this->colorsRepo->findOneBy(["name" => "Green"]))
            ->setMaximumValue(999)
            ->setIsReversedDirection(false);
        $game->addResource($life);
        $this->manager->persist($life);

        $ap = new Resource();
        $ap->setGame($game)
            ->setName("Action points")
            ->setAbreviation("AP")
            ->setDescription("Actions take action points in battle.")
            ->setColor($this->colorsRepo->findOneBy(["name" => "Orange"]))
            ->setMaximumValue(6)
            ->setIsReversedDirection(false);
        $game->addResource($ap);
        $this->manager->persist($ap);

        $stamina = new Resource();
        $stamina->setGame($game)
            ->setName("Stamina")
            ->setAbreviation("ST")
            ->setDescription("Physical actions take stamina.")
            ->setColor($this->colorsRepo->findOneBy(["name" => "Red"]))
            ->setMaximumValue(999)
            ->setIsReversedDirection(false);
        $game->addResource($stamina);
        $this->manager->persist($stamina);

        $mana = new Resource();
        $mana->setGame($game)
            ->setName("Mana")
            ->setAbreviation("MA")
            ->setDescription("Magical actions take stamina.")
            ->setColor($this->colorsRepo->findOneBy(["name" => "Blue"]))
            ->setMaximumValue(999)
            ->setIsReversedDirection(false);
        $game->addResource($mana);
        $this->manager->persist($mana);

        //System
        $game->setActionPointsResource($ap);
        $game->setLifeResource($life);
        $game->setMoneyTerm("Gold");
        $this->manager->persist($game);

        //Potencies

        $phyPotency = new PotencyAugmentator();
        $phyPotency->setGame($game)
            ->setName("Physical scaling")
            ->setAttribute($strength)
            ->setType(PotencyAugmentator::TYPE_ADD)
            ->setPercentCeiling(200);
        $game->addPotencyAugmentator($phyPotency);
        $this->manager->persist($phyPotency);

        $magPotency = new PotencyAugmentator();
        $magPotency->setGame($game)
            ->setName("Magical scaling")
            ->setAttribute($intel)
            ->setType(PotencyAugmentator::TYPE_ADD)
            ->setPercentCeiling(200);
        $game->addPotencyAugmentator($magPotency);
        $this->manager->persist($magPotency);

        $dexPotency = new PotencyAugmentator();
        $dexPotency->setGame($game)
            ->setName("Dexterity scaling")
            ->setAttribute($dexterity)
            ->setType(PotencyAugmentator::TYPE_ADD)
            ->setPercentCeiling(200);
        $game->addPotencyAugmentator($dexPotency);
        $this->manager->persist($dexPotency);

        //Equipment slots

        $head = new EquipmentSlot();
        $head->setName("Head")
            ->setGame($game);
        $game->addEquipmentSlot($head);
        $this->manager->persist($head);

        $body = new EquipmentSlot();
        $body->setName("Body")
            ->setGame($game);
        $game->addEquipmentSlot($body);
        $this->manager->persist($body);

        $hands = new EquipmentSlot();
        $hands->setName("Hands")
            ->setGame($game);
        $game->addEquipmentSlot($hands);
        $this->manager->persist($hands);

        $legs = new EquipmentSlot();
        $legs->setName("Legs")
            ->setGame($game);
        $game->addEquipmentSlot($legs);
        $this->manager->persist($legs);

        $feet = new EquipmentSlot();
        $feet->setName("Feet")
            ->setGame($game);
        $game->addEquipmentSlot($feet);
        $this->manager->persist($feet);

        //Flush
        $this->manager->flush();

    }

}