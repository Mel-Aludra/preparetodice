<?php

namespace App\DataFixtures;

use App\Entity\Attribute;
use App\Entity\CharacterAttribute;
use App\Entity\CharacterResource;
use App\Entity\Color;
use App\Entity\DamageNature;
use App\Entity\Game;
use App\Entity\GameCharacter;
use App\Entity\LoreBlock;
use App\Entity\LoreBlockElement;
use App\Entity\LoreTag;
use App\Entity\Resource;
use App\Entity\Skill;
use App\Entity\SkillCost;
use App\Entity\SkillDamageEffect;
use App\Entity\SkillGain;
use App\Entity\SkillHealEffect;
use App\Entity\User;
use App\Entity\UserGame;
use App\Entity\UserGameCharacter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    //Password encoder is required for user creation
    private $passwordEncoder;

    //Purpose: get services in dependancy injection
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    //Load main fixtures (main users, main games, ...)
    public function load(ObjectManager $manager)
    {
        //Colors
        $colorsDatas = [
            "Green" => ["#d9ead3", "#6aa84f"],
            "Orange" => ["#fce5cd", "#e69138"],
            "Blue" => ["#cfe2f3", "#3d85c6"],
            "Red" => ["#ffcdd2", "#b71c1c"],
            "Purple" => ["#D1C4E9", "#4A148C"],
            "Brown" => ["#D7CCC8", "#3E2723"]
        ];
        $colors = [];
        foreach($colorsDatas as $key => $colorsData) {
            $color = new Color();
            $color->setName($key);
            $color->setLight($colorsData[0]);
            $color->setDark($colorsData[1]);
            $manager->persist($color);
            $colors[] = $color;
        }

        //Final flush
        $manager->flush();
    }
}
