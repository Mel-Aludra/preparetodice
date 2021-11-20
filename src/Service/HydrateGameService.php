<?php

namespace App\Service;

use App\Entity\Attribute;
use App\Entity\CharacterAttribute;
use App\Entity\CharacterPassive;
use App\Entity\CharacterResource;
use App\Entity\CharacterSkill;
use App\Entity\Consumable;
use App\Entity\DamageNature;
use App\Entity\Defense;
use App\Entity\EquipmentSlot;
use App\Entity\Game;
use App\Entity\GameCharacter;
use App\Entity\HealOverTime;
use App\Entity\InventoryItem;
use App\Entity\Item;
use App\Entity\Passive;
use App\Entity\PotencyAugmentator;
use App\Entity\Resource;
use App\Entity\ResourceAlteration;
use App\Entity\Skill;
use App\Entity\SkillCost;
use App\Entity\SkillDamageEffect;
use App\Entity\SkillHealEffect;
use App\Entity\SkillStatusEffect;
use App\Entity\StatusEffect;
use App\Entity\Weapon;
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

    public function deemedUnfitHydratation(Game $game)
    {

        //Damage natures

        $physicalNature = new DamageNature();
        $physicalNature->setName("Physical")
            ->setAbreviation("PHY")
            ->setGame($game);
        $game->addDamageNature($physicalNature);
        $this->manager->persist($physicalNature);

        //Attributes

        $strength = new Attribute();
        $strength->setGame($game)
            ->setName("Force")
            ->setAbreviation("FOR")
            ->setMaximumValue(99)
            ->setColor($this->colorsRepo->findOneBy(["name" => "Red"]));
        $game->addAttribute($strength);
        $this->manager->persist($strength);

        $dex = new Attribute();
        $dex->setGame($game)
            ->setName("Dextérité")
            ->setAbreviation("DEX")
            ->setMaximumValue(99)
            ->setColor($this->colorsRepo->findOneBy(["name" => "Purple"]));
        $game->addAttribute($dex);
        $this->manager->persist($dex);

        $obs = new Attribute();
        $obs->setGame($game)
            ->setName("Observation")
            ->setAbreviation("OBS")
            ->setMaximumValue(99)
            ->setColor($this->colorsRepo->findOneBy(["name" => "Brown"]));
        $game->addAttribute($obs);
        $this->manager->persist($obs);

        $log = new Attribute();
        $log->setGame($game)
            ->setName("Logique")
            ->setAbreviation("LOG")
            ->setMaximumValue(99)
            ->setColor($this->colorsRepo->findOneBy(["name" => "Brown"]));
        $game->addAttribute($log);
        $this->manager->persist($log);

        //Resources

        $vig = new Resource();
        $vig->setGame($game)
            ->setName("Vigueur")
            ->setAbreviation("VI")
            ->setDescription("Cette ressource représente la force vitale du personnage.")
            ->setColor($this->colorsRepo->findOneBy(["name" => "Blue"]))
            ->setMaximumValue(100)
            ->setIsReversedDirection(false);
        $game->addResource($vig);
        $this->manager->persist($vig);

        $ap = new Resource();
        $ap->setGame($game)
            ->setName("Points d'action")
            ->setAbreviation("PA")
            ->setDescription("Représente le nombre d'actions réalisables par tour.")
            ->setColor($this->colorsRepo->findOneBy(["name" => "Orange"]))
            ->setMaximumValue(2)
            ->setIsReversedDirection(false);
        $game->addResource($ap);
        $this->manager->persist($ap);

        //System
        $game->setActionPointsResource($ap);
        $game->setLifeResource($vig);
        $game->setMoneyTerm("Argent");
        $game->setName("Deemed Unfit");
        $game->setDescription("Comme les autres personnes qui vous accompagnent dans ce voyage, vous venez d'être condamné·e à un exil sur la planète Narayan.");
        $this->manager->persist($game);

        //Potencies

        $phyPotency = new PotencyAugmentator();
        $phyPotency->setGame($game)
            ->setName("^ Force")
            ->setAttribute($strength)
            ->setType(PotencyAugmentator::TYPE_ADD_DIVIDED_TEN);
        $game->addPotencyAugmentator($phyPotency);
        $this->manager->persist($phyPotency);

        $dexPotency = new PotencyAugmentator();
        $dexPotency->setGame($game)
            ->setName("^ Dextérité")
            ->setAttribute($dex)
            ->setType(PotencyAugmentator::TYPE_ADD_DIVIDED_TEN);
        $game->addPotencyAugmentator($dexPotency);
        $this->manager->persist($dexPotency);

        //Passives
        $najmaPassive = new Passive();
        $najmaPassive->setName("Expérience du terrain")
            ->setDescription("Najma, du fait de son travail en tant que cheffe des opérations de reconquête, bénéficie d'un bonus de 20 aux jets d'observation liés à l'exploration.")
            ->setGame($game);
        $calebPassive = new Passive();
        $calebPassive->setName("Logique scientifique")
            ->setDescription("Caleb, du fait de son travail à ITA, bénéficie d'un bonus de 20 aux jets de logique liés à des éléments scientifiques ou technologiques.")
            ->setGame($game);
        $willowPassive = new Passive();
        $willowPassive->setName("Âme guerrière")
            ->setDescription("Willow a des réminiscences de sa vie d'avant. Un quotidien de guerre, où aucun jour ne se passait sans se battre. Elle peut désormais utiliser deux actions principales par tour.")
            ->setGame($game);
        $resourceAlt = new ResourceAlteration();
        $resourceAlt->setPassive($willowPassive);
        $willowPassive->addResourceAlteration($resourceAlt);
        $resourceAlt->setCalculationType("points");
        $resourceAlt->setIsNegative(0);
        $resourceAlt->setValue(1);
        $resourceAlt->setResource($ap);
        $autoRegenPassive = new Passive();
        $autoRegenPassive->setName("Auto régénération")
            ->setDescription("L'Origine parvient à se régénérer à une vitesse importante et regagne de la vigueur à chaque tour.")
            ->setGame($game);
        $hot = new HealOverTime();
        $hot->setPassive($autoRegenPassive);
        $autoRegenPassive->addHealOverTime($hot);
        $hot->setResource($vig);
        $hot->setValue(20);
        $hot->setCalculationType("points");
        $this->manager->persist($resourceAlt);
        $this->manager->persist($hot);
        $this->manager->persist($najmaPassive);
        $this->manager->persist($calebPassive);
        $this->manager->persist($willowPassive);
        $this->manager->persist($autoRegenPassive);
        $game->addPassive($najmaPassive)->addPassive($calebPassive)->addPassive($willowPassive)->addPassive($autoRegenPassive);
        $this->manager->persist($game);

        //Najma
        $character = new GameCharacter();
        $character->setName("Najma");
        $character->setDescription("Accès document personnage : https://tinyurl.com/26k7p5t2");
        $character->setTeam(GameCharacter::TEAM_ALLIES);
        $characterPassive = new CharacterPassive();
        $characterPassive->setGameCharacter($character); $characterPassive->setPassive($najmaPassive); $character->addCharacterPassive($characterPassive);
        $this->manager->persist($characterPassive);
        $this->persistCharacter($game, $character, ["FOR" => 30, "DEX" => 30, "OBS" => 50, "LOG" => 40]);
        $najma = $character;

        //Caleb
        $character = new GameCharacter();
        $character->setName("Caleb");
        $character->setDescription("Accès document personnage : https://tinyurl.com/mrc86nya");
        $character->setTeam(GameCharacter::TEAM_ALLIES);
        $characterPassive->setGameCharacter($character); $characterPassive->setPassive($calebPassive); $character->addCharacterPassive($characterPassive);
        $this->manager->persist($characterPassive);
        $this->persistCharacter($game, $character, ["FOR" => 20, "DEX" => 50, "OBS" => 20, "LOG" => 40]);
        $caleb = $character;

        //Willow
        $character = new GameCharacter();
        $character->setName("Willow");
        $character->setDescription("Accès document personnage : https://tinyurl.com/2haapuzx");
        $character->setTeam(GameCharacter::TEAM_ALLIES);
        $this->persistCharacter($game, $character, ["FOR" => 40, "DEX" => 30, "OBS" => 30, "LOG" => 30]);
        $willow = $character;

        //Être sans visage
        $character = new GameCharacter();
        $character->setName("Être sans visage");
        $character->setDescription("Un être de forme humanoïde, aux formes courbées et sans visage. Il est constitué d'une matière très sombre qui semble, aux extrémités, volatile.");
        $this->persistCharacter($game, $character);
        $etreSansVisage = $character;

        //Rôdeur sans visage
        $character = new GameCharacter();
        $character->setName("Rôdeur sans visage");
        $character->setDescription("Un être de forme animale, sans visage, rappelant celle d'un félin de taille imposante. Il est constitué d'une matière très ombre qui semble, aux extrémités, volatile.");
        $this->persistCharacter($game, $character);
        $rodeurSansVisage = $character;

        //Traqueur
        $character = new GameCharacter();
        $character->setName("Le Traqueur");
        $character->setDescription("Un être de forme humanoïde, au corps fin, dont le visage est seulement affublé de deux yeux blancs qui semblent épier chaque mouvement.");
        $this->persistCharacter($game, $character);
        $traqueur = $character;

        //Sphère
        $character = new GameCharacter();
        $character->setName("L'Origine");
        $character->setDescription("Une sphère formée de matière volatile excessivement sombre. Des éclats noirs se détachent de la sphère pour former un anneau qui tournoie rapidement autour.");
        $characterPassive = new CharacterPassive();
        $characterPassive->setGameCharacter($character); $characterPassive->setPassive($autoRegenPassive); $character->addCharacterPassive($characterPassive);
        $this->manager->persist($characterPassive);
        $this->persistCharacter($game, $character);
        $sphere = $character;

        //Weapons
        $weaponsData = [];
        $weaponsData[] = ["Sans arme", "Condition de réussite sur Vigueur", 4, 0, "strengthScaling"];
        $weaponsData[] = ["Arme contondante improvisée", "Arme à 1 main - Condition de réussite sur Vigueur et Force", 3, 1, "strengthScaling"];
        $weaponsData[] = ["Barre en métal", "Arme à 1 main - Condition de réussite sur Vigueur et Force", 3, 2, "strengthScaling"];
        $weaponsData[] = ["Batte", "Arme à 2 mains - Condition de réussite sur Vigueur et Force", 3, 4, "strengthScaling"];
        $weaponsData[] = ["Arme tranchante improvisée", "Arme à 1 main - Condition de réussite sur Vigueur et Dextérité", 3, 1, "dexScaling"];
        $weaponsData[] = ["Couteau", "Arme à 1 main - Condition de réussite sur Vigueur et Dextérité", 3, 2, "dexScaling"];
        $weaponsData[] = ["Machette", "Arme à 1 main - Condition de réussite sur Vigueur et Dextérité", 5, 3, "dexScaling"];
        $weaponsData[] = ["Épée décorative", "Arme à 2 mains - Condition de réussite sur Vigueur, Force et Dextérité", 8, 1, "bothScaling"];
        $weaponsData[] = ["Sac de briques", "Arme à 1 main - Condition de réussite sur Vigueur, Force et Dextérité", 10, 0, "bothScaling"];
        $weaponsData[] = ["Pistolet", "Arme à 1 main - Condition de réussite sur Vigueur, Force et Dextérité - Nécessite des balles de pistolet", 2, 25, "noScaling"];
        $weaponsData[] = ["Fusil", "Arme à 2 mains - Condition de réussite sur Vigueur, Force et Dextérité - Nécessite des balles de fusil", 3, 35, "noScaling"];
        foreach($weaponsData as $weaponsDatum) {

            $weapon = new Weapon();
            $weapon->setGame($game); $game->addWeapon($weapon);
            $weapon->setName($weaponsDatum[0]);
            $weapon->setDescription($weaponsDatum[1]);

            $cost = new SkillCost(); $cost->setWeapon($weapon); $weapon->addSkillCost($cost);
            $cost->setResource($ap)->setValue(1)->setCalculationType("points");
            $this->manager->persist($cost);
            $cost = new SkillCost(); $cost->setWeapon($weapon); $weapon->addSkillCost($cost);
            $cost->setResource($vig)->setValue($weaponsDatum[2])->setCalculationType("points");
            $this->manager->persist($cost);

            $skillDamage = new SkillDamageEffect(); $skillDamage->setWeapon($weapon); $weapon->addSkillDamageEffect($skillDamage);
            $skillDamage->setResource($vig)->setValue($weaponsDatum[3])->setCalculationType("points")->setDamageNature($physicalNature)->setIgnoreDefense(0);
            if($weaponsDatum[4] == "strengthScaling") {
                $skillDamage->addPotencyAugmentator($phyPotency);
            }
            else if($weaponsDatum[4] == "dexScaling") {
                $skillDamage->addPotencyAugmentator($dexPotency);
            }
            else if($weaponsDatum[4] == "bothScaling") {
                $skillDamage->addPotencyAugmentator($phyPotency);
                $skillDamage->addPotencyAugmentator($dexPotency);
            }
            $this->manager->persist($skillDamage);

            $this->manager->persist($weapon);

        }

        //Status effects
        $statusEffectsData = [];
        $statusEffectsData[] = ["Plaie à la tête", null, 8];
        $statusEffectsData[] = ["Plaie au corps", "Une autre plaie au même endroit pourrait aggraver la blessure, toucher des organes et entraîner un décès.", 12];
        $statusEffectsData[] = ["Plaie au bras droit", null, 5];
        $statusEffectsData[] = ["Plaie au bras gauche", null, 5];
        $statusEffectsData[] = ["Plaie à la jambe droite", null, 5];
        $statusEffectsData[] = ["Plaie à la jambe gauche", null, 5];
        $statusEffectsData[] = ["Fracture du crâne", "Une autre fracture au même endroit pourrait aggraver la blessure, provoquer des dégâts cérébraux et entraîner un décès.", 6];
        $statusEffectsData[] = ["Fracture des côtes", "Une autre fracture au même endroit pourrait aggraver la blessure, perforer un organe et entraîner un décès.", 12];
        $statusEffectsData[] = ["Fracture du bras droit", null, 10];
        $statusEffectsData[] = ["Fracture du bras gauche", null, 8];
        $statusEffectsData[] = ["Fracture de la jambe droite", null, 12];
        $statusEffectsData[] = ["Fracture de la jambe gauche", null, 12];
        $statusEffectsData[] = ["Fracture supplémentaire", "Fracture supplémentaire au niveau d'un membre déjà fracturé.", 4];
        $statusEffectsData[] = ["Plaie non-prise en charge", "Sans prise en charge rapide, l'hémorragie peut s'aggraver et la plaie peut s'infecter.", 30];
        $statusEffectsData[] = ["Hémorragie", "Entraîne un décès sans prise en charge rapide.", 40];
        $statusEffectsData[] = ["Infection", "Une plaie s'est infectée et affecte le métabolisme.", 8];
        $statusEffectsData[] = ["Fracture d'un membre non-prise en charge", "Sans prise en charge, le moindre mouvement provoque une douleur violente.", 50];
        $statusEffectsData[] = ["Fracture d'un membre en partie prise en charge", "La fracture est en partie prise en charge mais bouger reste douloureux.", 25];
        $statusEffectsData[] = ["Poison", "Un poison affecte le métabolisme.", 20];
        $statusEffectsData[] = ["Gêne respiratoire", "Sensation d'oppression au niveau du thorax et de gêne à la respiration.", 5];
        $statusEffectsData[] = ["Gêne respiratoire importante", "Sensation d'oppression au niveau du thorax et de gêne importante à la respiration.", 10];
        $statusEffectsData[] = ["Détresse respiratoire", "Sensation d'oppression extrême au niveau du thorax. La respiration est très faible.", 40];
        $statusEffectsData[] = ["Fatigue", "Sensation générale de fatigue et nausées passagères.", 1];
        $statusEffectsData[] = ["Posture défensive", "En cas d'attaque : jet de 100 sur la vigueur pour tenter d'esquiver ou de parer.", null];
        $statusEffectsData[] = ["Protégé·e", "Un·e allié·e encaisse les coups à votre place jusqu'au prochain tour.", null];
        $statusEffectsData[] = ["Protège un·e allié·e", "Vous encaissez les coups à la place d'un·e allié·e.", null];
        foreach($statusEffectsData as $statusEffectsDatum) {
            $statusEffect = new StatusEffect(); $statusEffect->setGame($game); $game->addStatusEffect($statusEffect);
            $statusEffect->setName($statusEffectsDatum[0])->setDescription($statusEffectsDatum[1]);
            if($statusEffectsDatum[2] !== null) {
                $resourceAlt = new ResourceAlteration(); $resourceAlt->setStatusEffect($statusEffect); $statusEffect->addResourceAlteration($resourceAlt);
                $resourceAlt->setIsNegative(1)->setValue($statusEffectsDatum[2])->setCalculationType("points")->setResource($vig);
            }
            $this->manager->persist($resourceAlt);
            $this->manager->persist($statusEffect);
            if($statusEffect->getName() == "Posture défensive") { $postureDefensive = $statusEffect; }
            if($statusEffect->getName() == "Protégé·e") { $protege = $statusEffect; }
            if($statusEffect->getName() == "Protège un·e allié·e") { $protegeUnAllie = $statusEffect; }
        }

        //Consumables
        $consumablesData = [];
        $consumablesData[] = ["Antiseptique", "Dose d'antiseptique à pulvériser sur une plaie. Permet d'éviter une infection."];
        $consumablesData[] = ["Bandage médical", "Bandage médical permettant de traiter une plaie en stoppant l'hémorragie."];
        $consumablesData[] = ["Bandage confectionné", "Bandage de fortune permettant de traiter une plaie en stoppant l'hémorragie. Il y a un risque accru d'infection de la plaie en utilisant cet objet."];
        $consumablesData[] = ["Attelle médicale", "Attelle rigide moderne et adaptable permettant de traiter la fracture de n'importe quel membre. En cas de fracture de la jambe, elle autorise l'appui sans forcer. Nécessite un professionnel pour être posée correctement."];
        $consumablesData[] = ["Attelle confectionnée", "Attelle de fortune permettant de traiter la fracture d'un membre. Bien moins efficace qu'une attelle médicale."];
        $consumablesData[] = ["Antivenin", "Dose d'antivenin sous forme de gel. Permet de traiter un empoisonnement. S'applique à l'endroit de la piqûre ou de la morsure."];
        $consumablesData[] = ["Balle de pistolet", null];
        $consumablesData[] = ["Balle de fusil", null];
        $consumablesData[] = ["Bouteille de vin rouge", "Une bouteille de vin rouge. Une cuvée plutôt banale sur Terre, mais qui ne doit pas se trouver facilement sur Narayan."];
        $consumablesData[] = ["Bière", "Une bouteille de bière blanche d'une marque connue."];
        $consumablesData[] = ["Alcool fort inconnu", "Une bouteille dans l'odeur ne fait aucun doute : il s'agit d'alcool. Le liquide est bleu nuit mais a l'air de briller très légèrement. Une seule étiquette accompagne la bouteille et indique \"60°\"."];
        foreach($consumablesData as $consumablesDatum) {
            $consumable = new Consumable();
            $consumable->setGame($game); $game->addConsumable($consumable);
            $consumable->setName($consumablesDatum[0])->setDescription($consumablesDatum[1]);
            $this->manager->persist($consumable);
        }

        //Skills
        //0 => name / 1 => description / 2 => cost pa / 3 => cost vi / 4 => vi damage / 5 => vi heal / 6 => se 1 / 7 => se 2
        $skillsData = [];
        $skillsData[] = [
            "Attaque sans arme", "Action principale. Condition de réussite sur Vigueur. En cas d'arme équipée, se reporter à la section 'weapons'.",
            1, 4, 0, null,
            null, null
        ];
        $skillsData[] = [
            "Défense", "Action principale. Actif jusqu'au prochain tour. En cas d'attaque ennemie, un jet sur la vigueur permettra d'éviter une blessure.",
            1, 3, null, null,
            $postureDefensive, null
        ];
        $skillsData[] = [
            "Changement d'arme", "Action principale. Change l'arme équipée par une autre arme dans l'inventaire.",
            1, null, null, null,
            null, null
        ];
        $skillsData[] = [
            "Analyse", "Action secondaire. Permet d'anticiper la prochaine action d'une cible.",
            null, 2, null, null,
            null, null
        ];
        $skillsData[] = [
            "Protection allié·e", "Action secondaire. Actif jusqu'au prochain tour. Cible un·e allié·e et encaisse les coups à sa place.",
            null, 4, null, null,
            $protegeUnAllie, $protege
        ];
        $skillsData[] = [
            "Attaque létale (action spéciale de groupe)", "Action spéciale de groupe. Doit être lancé par l'ensemble des allié·e·s au même tour. Permet d'achever une cible. La cible réalise un jet sur sa vigueur pour tenter de survivre.",
            null, null, null, null,
            null, null
        ];
        $skillsData[] = [
            "Récupération (action spéciale de groupe)", "Attaque spéciale de groupe. Doit être lancé par l'ensemble des allié·e·s au même tour. L'un·e des allié·e·s distrait les adversaires tandis que les deux autres récupèrent de la vigueur.",
            null, null, null, 25,
            null, null
        ];
        $skillsData[] = [
            "Fuite (action spéciale de groupe)", "Action spéciale de groupe. Doit être lancé par l'ensemble des allié·e·s au même tour. Chaque allié·e jette un dé par ennemi. Si un seul de ces dés est > à 95, la fuite échoue.",
            null, null, null, null,
            null, null
        ];
        $skillsData[] = [
            "Action contextuelle (action spéciale de groupe)", "Action spéciale de groupe. Doit être lancé par l'ensemble des allié·e·s au même tour. Les allié·e·s décident d'une action de groupe contextuelle.",
            null, null, null, null,
            null, null
        ];
        $skillsData[] = [
            "Coup", "Cible un adversaire. L'être donne un coup de poing à sa cible.",
            1, null, 5, null,
            null, null
        ];
        $skillsData[] = [
            "Lame éphémère", "Cible un adversaire. L'être matérialise une lame courte et tranche sa cible.",
            1, null, 5, null,
            null, null
        ];
        $skillsData[] = [
            "Massue éphémère", "Cible une personne. L'ennemi matérialise une massue avec laquelle il frappe sa cible de manière latérale.",
            1, null, 5, null,
            null, null
        ];
        $skillsData[] = [
            "Rugissement matérialisé", "Cible TOUS les adversaires. La rôdeur pousse un rugissement qui repousse violemment ses cibles.",
            1, null, 5, null,
            null, null
        ];
        $skillsData[] = [
            "Plaquage", "Cible un adversaire. L'être se jette sur sa cible et la plaque violemment.",
            1, null, 15, null,
            null, null
        ];
        $skillsData[] = [
            "Férocité", "Cible un adversaire. L'être plante ses crocs dans l'un des membres de sa cible et s'acharne dessus.",
            1, null, 10, null,
            null, null
        ];
        $skillsData[] = [
            "Lacération", "Cible un adversaire. Le rôdeur déploie des griffes acérées et lacère sa cible.",
            1, null, 10, null,
            null, null
        ];
        $skillsData[] = [
            "Observation", "Le Traqueur observe les mouvements de ses adversaires.",
            1, null, null, 25,
            null, null
        ];
        $skillsData[] = [
            "Lance colossale", "Le Traqueur matérialise une lance colossale d'un noir profond qu'il projette avec violence sur sa cible.",
            1, null, 45, null,
            null, null
        ];
        $skillsData[] = [
            "Tornade", "Cible TOUS les adversaires. L'Origine génère une tornade qui projette violemment les cibles.",
            1, null, 8, null,
            null, null
        ];
        $skillsData[] = [
            "Éclats lacérants", "Cible TOUS les adversaires. L'Origine génère une rafale d'éclat tranchants qui s'abattent sur les cibles.",
            1, null, 8, null,
            null, null
        ];
        $skillsData[] = [
            "Lame noire", "L'Origine matérialise une lame noire qui s'abat sur sa cible.",
            1, null, 20, null,
            null, null
        ];
        $skillsData[] = [
            "Absorption vitale", "L'Origine utilise la Shiva pour puiser dans les ressources de sa cible. Il régénère sa vigueur de 15.",
            1, null, 15, 15,
            null, null
        ];
        $skillsData[] = [
            "Régénération", "Lorsque l'ennemi ne peut plus rien faire.",
            null, null, null, 20,
            null, null
        ];
        foreach($skillsData as $datum) {
            $skill = new Skill(); $skill->setGame($game); $game->addSkill($skill);
            $skill->setName($datum[0])->setDescription($datum[1]);
            if($datum[2] !== null) {
                $skillCost = new SkillCost(); $skill->addSkillCost($skillCost);
                $skillCost->setResource($ap)->setCalculationType("points")->setSkill($skill)->setValue($datum[2]);
                $this->manager->persist($skillCost);
            }
            if($datum[3] !== null) {
                $skillCost = new SkillCost(); $skill->addSkillCost($skillCost);
                $skillCost->setResource($vig)->setCalculationType("points")->setSkill($skill)->setValue($datum[3]);
                $this->manager->persist($skillCost);
            }
            if($datum[4] !== null) {
                $skillDamage = new SkillDamageEffect(); $skillDamage->setSkill($skill); $skill->addSkillDamageEffect($skillDamage);
                if($skill->getName() == "Attaque sans arme") {
                    $skillDamage->addPotencyAugmentator($phyPotency);
                }
                $skillDamage->setValue($datum[4])->setCalculationType("points")->setDamageNature($physicalNature)->setResource($vig)->setIgnoreDefense(0);
                $this->manager->persist($skillDamage);
            }
            if($datum[5] !== null) {
                $skillDamage = new SkillHealEffect(); $skillDamage->setSkill($skill); $skill->addSkillHealEffect($skillDamage);
                $skillDamage->setValue($datum[5])->setCalculationType("points")->setResource($vig);
                $this->manager->persist($skillDamage);
            }
            if($datum[6] !== null) {
                $skillSe = new SkillStatusEffect(); $skillSe->setSkill($skill); $skill->addSkillStatusEffect($skillSe);
                $skillSe->setStatusEffect($datum[6])->setDuration(1);
                $this->manager->persist($skillSe);
            }
            if($datum[7] !== null) {
                $skillSe = new SkillStatusEffect(); $skillSe->setSkill($skill); $skill->addSkillStatusEffect($skillSe);
                $skillSe->setStatusEffect($datum[7])->setDuration(1);
                $this->manager->persist($skillSe);
            }
            $this->manager->persist($skill);
        }

        //Characters skills
        $players = [$najma, $caleb, $willow];
        $skills = ["Attaque sans arme", "Défense", "Changement d'arme", "Analyse", "Protection allié·e", "Attaque létale (action spéciale de groupe)", "Récupération (action spéciale de groupe)", "Fuite (action spéciale de groupe)", "Action contextuelle (action spéciale de groupe)"];
        foreach($players as $player) {
            foreach($skills as $skillName) {
                foreach($game->getSkills() as $skill) {
                    if($skill->getName() == $skillName) {
                        $characterSkill = new CharacterSkill();
                        $characterSkill->setSkill($skill); $player->addCharacterSkill($characterSkill); $characterSkill->setGameCharacter($player);
                        $this->manager->persist($characterSkill);
                    }
                }
            }
        }

        //Etre sans visage
        $treatedCharacter = $etreSansVisage;
        $skills = ["Coup", "Lame éphémère", "Massue éphémère", "Régénération"];
        foreach($skills as $skillName) {
            foreach($game->getSkills() as $skill) {
                if($skill->getName() == $skillName) {
                    $characterSkill = new CharacterSkill();
                    $characterSkill->setSkill($skill); $treatedCharacter->addCharacterSkill($characterSkill); $characterSkill->setGameCharacter($treatedCharacter);
                    $this->manager->persist($characterSkill);
                }
            }
        }

        //Rodeur sans visage
        $treatedCharacter = $rodeurSansVisage;
        $skills = ["Rugissement matérialisé", "Plaquage", "Férocité", "Lacération", "Régénération"];
        foreach($skills as $skillName) {
            foreach($game->getSkills() as $skill) {
                if($skill->getName() == $skillName) {
                    $characterSkill = new CharacterSkill();
                    $characterSkill->setSkill($skill); $treatedCharacter->addCharacterSkill($characterSkill); $characterSkill->setGameCharacter($treatedCharacter);
                    $this->manager->persist($characterSkill);
                }
            }
        }

        //Traqueur
        $treatedCharacter = $traqueur;
        $skills = ["Observation", "Lance colossale", "Régénération"];
        foreach($skills as $skillName) {
            foreach($game->getSkills() as $skill) {
                if($skill->getName() == $skillName) {
                    $characterSkill = new CharacterSkill();
                    $characterSkill->setSkill($skill); $treatedCharacter->addCharacterSkill($characterSkill); $characterSkill->setGameCharacter($treatedCharacter);
                    $this->manager->persist($characterSkill);
                }
            }
        }

        //Traqueur
        $treatedCharacter = $sphere;
        $skills = ["Tornade", "Éclats lacérants", "Lame noire", "Absorption vitale", "Régénération"];
        foreach($skills as $skillName) {
            foreach($game->getSkills() as $skill) {
                if($skill->getName() == $skillName) {
                    $characterSkill = new CharacterSkill();
                    $characterSkill->setSkill($skill); $treatedCharacter->addCharacterSkill($characterSkill); $characterSkill->setGameCharacter($treatedCharacter);
                    $this->manager->persist($characterSkill);
                }
            }
        }

        //Items
        $itemsData = [];
        $itemsData[] = ["Cylindre métallique cassé", "Un cylindre métallique présentant divers boutons et une aiguille à son extrémité. Une partie vitrée a été cassée. Des traces séchées d'un résidu sombre parsème le métal."];
        $itemsData[] = ["Téléphone portable cassé", "Un téléphone portable, noir et de conception simple. Le tactile et les boutons ne répondent plus. Il est figé sur une conversation avec un certain Seung."];
        $itemsData[] = ["Téléphone portable", "Un téléphone portable, noir et de conception simple. Il est verrouillé."];
        $itemsData[] = ["Cylindre métallique à seringue", "Un cylindre métallique avec une aiguille à son extrémité. Une partie transparente du cylindre permet de voir une matière excessivement noire à l'intérieur. Probablement de la Shiva."];
        $itemsData[] = ["Clé à bout cylindrique", "Une clé moderne, assez courte, au bout cylindrique, dont la forme suggère qu'elle peut être insérée dans une machine davantage que dans une porte."];
        $itemsData[] = ["Carnet gris", "Un carnet gris sur lequel des notes ont été prises sur la faune et la flore de Narayan."];
        $itemsData[] = ["Inhalateur", "Un inhalateur médical conçu pour traiter les crises d'asthmes."];
        $itemsData[] = ["Cylindre métallique à seringue", "Un cylindre métallique présentant divers boutons et une aiguille à son extrémité. Une partie transparente du cylindre permet de voir une matière excessivement noire à l'intérieur. Probablement de la Shiva."];
        $itemsData[] = ["Tablette de Romane Vance", "Une tablette simple, dotée d'un écran assez généreux. Un code à 8 chiffres est demandé lorsqu'on tente de la déverrouiller."];
        $itemsData[] = ["Clé en métal", "Une clé simple, en métal."];
        $itemsData[] = ["Code de secours de la Cité", "Une clé USB qui contient, d'après le document qui y était attaché, un code de secours crypté permettant d'ouvrir les portes de la Cité en cas de besoin."];
        $itemsData[] = ["Clé de la maison témoin", "Une clé moderne sur laquelle est indiqué \"Maison témoin\"."];
        $itemsData[] = ["Clé USB", "Une clé USB réalisée dans un métal solide. Une simple pression au centre permet de retirer le capuchon."];
        $itemsData[] = ["Scanneur de terrain de l'Horizon", "Sur Narayan, aucune carte n'est disponible dans le terminal du scanneur. Cependant, la zone du Hameau est quand même délimitée, ce qui permet de connaître sa position approximative."];
        $itemsData[] = ["Clé de voiture", "La clé d'une voiture. Elle a été trouvée sur une femme qui tentait a priori d'y accéder pour fuir."];
        $itemsData[] = ["Pistolet cassé", "Un pistolet hors d'état d'usage."];
        foreach($itemsData as $datum) {
            $item = new Item(); $item->setGame($game); $game->addItem($item);
            $item->setName($datum[0]); $item->setDescription($datum[1]);
            $this->manager->persist($item);
            if($item->getName() === "Scanneur de terrain de l'Horizon") {
                $inventoryItem = new InventoryItem();
                $inventoryItem->setGameCharacter($najma); $najma->addInventoryItem($inventoryItem);
                $inventoryItem->setQuantity(1)->setItem($item);
                $this->manager->persist($najma);
                $this->manager->persist($inventoryItem);
            }
        }

        //Flush
        $this->manager->persist($game);
        $this->manager->flush();

    }

    private function persistCharacter(Game $game, GameCharacter $character, $attributesOptions = [])
    {
        $character->setGame($game);
        $game->addGameCharacter($character);

        foreach($game->getResources() as $resource) {
            $characterResource = new CharacterResource();
            $characterResource->setResource($resource);
            $characterResource->setGameCharacter($character);
            $characterResource->setActive(1);
            if($resource->getAbreviation() == "PA") {
                $characterResource->setValue(1)->setCurrentValue(1)->setFinalValue(1);
            } else {
                $characterResource->setValue(100)->setCurrentValue(100)->setFinalValue(100);
            }
            $character->addCharacterResource($characterResource);
            $this->manager->persist($characterResource);
        }

        foreach($game->getAttributes() as $attribute) {
            $characterAttribute = new CharacterAttribute();
            $characterAttribute->setAttribute($attribute);
            $characterAttribute->setGameCharacter($character);
            $characterAttribute->setActive(1);
            $characterAttribute->setValue(0)->setFinalValue(0);
            foreach($attributesOptions as $abr => $value) {
                if($abr === $attribute->getAbreviation()) {
                    $characterAttribute->setValue($value)->setFinalValue($value);
                }
            }
            $character->addCharacterAttribute($characterAttribute);
            $this->manager->persist($characterAttribute);
        }

        $this->manager->persist($character);
        $this->manager->persist($game);
    }

}