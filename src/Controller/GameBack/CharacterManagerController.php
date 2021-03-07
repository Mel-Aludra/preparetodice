<?php

namespace App\Controller\GameBack;

use App\Entity\EquippedGear;
use App\Entity\GameCharacter;
use App\Form\GameBack\CharacterInventoryType;
use App\Form\GameBack\CharacterSkillsType;
use App\Form\GameBack\CharacterIdentityType;
use App\Service\CharacterEquipmentService;
use App\Service\CharacteristicsManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BattleController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/character-manager")
 */
class CharacterManagerController extends Controller
{
    /**
     * @Route("/{gameCharacter}/equipment", name="gameBack_characterManager_equipment")
     * @param GameCharacter $gameCharacter
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param CharacterEquipmentService $characterEquipmentService
     * @param CharacteristicsManager $characteristicsManager
     * @return Response
     */
    public function equipment(GameCharacter $gameCharacter, Request $request, EntityManagerInterface $manager, CharacterEquipmentService $characterEquipmentService, CharacteristicsManager $characteristicsManager)
    {

        //Manage post for weapon
        if(isset($_POST["weapon"])) {

            //We check if elements are not the same
            if(($gameCharacter->getEquippedWeapon() === null && $_POST["weapon"] !== "null") || ($gameCharacter->getEquippedWeapon() !== null && (int) $gameCharacter->getEquippedWeapon()->getId() !== (int) $_POST["weapon"])) {

                //If weapon is unequipped
                if($_POST["weapon"] === "null") {
                    $gameCharacter->setEquippedWeapon(null);
                    $manager->persist($gameCharacter);
                    $this->addFlash("success", "Weapon is now unequipped");
                }

                //Else we check if weapon is own by character
                $inventoryWeapon = $characterEquipmentService->getInventoryWeaponFromId($gameCharacter, $_POST["weapon"]);
                if($inventoryWeapon !== null) {
                    $gameCharacter->setEquippedWeapon($inventoryWeapon);
                    $manager->persist($inventoryWeapon);
                    $this->addFlash("success", "Weapon " . $inventoryWeapon->getWeapon()->getName() . " is now equipped.");
                }

            }

        }

        //Manage post for slots
        if(isset($_POST["slots"])) {
            foreach($_POST["slots"] as $postedSlotId => $postedInventoryGearId) {

                //We get equipment slot
                $equipmentSlot = $this->getGame()->getEquipmentSlotFromId($postedSlotId);
                if($equipmentSlot !== null) {

                    //We get equipped gear and inventory gear
                    $equippedGear = $characterEquipmentService->getCharacterEquippedGearFromSlot($gameCharacter, $equipmentSlot);
                    $inventoryGear = $characterEquipmentService->getInventoryGearFromId($gameCharacter, $postedInventoryGearId);

                    //Inventory gear null and equipped gear exists = unequip gear
                    if($equippedGear !== null && $inventoryGear === null) {
                        $gameCharacter->removeEquippedGear($equippedGear);
                        $manager->remove($equippedGear);
                        $manager->persist($equippedGear);
                        $this->addFlash("success", "Slot " . $equippedGear->getEquipmentSlot()->getName() . " is now empty");
                    }

                    //Equipped gear null and inventory gear not null = add equipment
                    elseif($equippedGear === null && $inventoryGear !== null) {
                        $equippedGear = new EquippedGear();
                        $equippedGear->setInventoryGear($inventoryGear);
                        $equippedGear->setEquipmentSlot($equipmentSlot);
                        $equippedGear->setGameCharacter($gameCharacter);
                        $manager->persist($equippedGear);
                        $gameCharacter->addEquippedGear($equippedGear);
                        $manager->persist($gameCharacter);
                        $this->addFlash("success", $inventoryGear->getGear()->getName() . " is now equiped on slot " . $equipmentSlot->getName());
                    }

                    //Both not null, if not the same = update equipment
                    elseif($equippedGear !== null && $inventoryGear !== null && $equippedGear->getInventoryGear()->getId() !== $inventoryGear->getId()) {
                        $equippedGear->setInventoryGear($inventoryGear);
                        $manager->persist($equippedGear);
                        $this->addFlash("success", $inventoryGear->getGear()->getName() . " is now equiped on slot " . $equipmentSlot->getName());
                    }

                }

            }
        }

        //Redirection
        if(isset($_POST["weapon"]) || isset($_POST["slots"])) {
            $characteristicsManager->calculateCharacteristics($gameCharacter);
            return $this->redirectToRoute('gameBack_characterSheet', ['game' => $this->getGame()->getId(), 'gameCharacter' => $gameCharacter->getId()]);
        }

        //Flush and return view
        $manager->flush();
        return $this->render('back/character-manager/equipment.html.twig', [
            'character' => $gameCharacter,
            'equipmentSlots' => $this->getGame()->getEquipmentSlots()
        ]);
    }

    /**
     * @Route("/{gameCharacter}/skills", name="gameBack_characterManager_skills")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param GameCharacter|null $gameCharacter
     * @return Response
     */
    public function skills(EntityManagerInterface $manager, Request $request, ?GameCharacter $gameCharacter)
    {
        $this->checkEntityGameContext($gameCharacter);

        //Create form and handle request
        $form = $this->createForm(CharacterSkillsType::class, $gameCharacter);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            //Persist skills and character
            foreach($gameCharacter->getCharacterSkills() as $child) {
                $child->setGameCharacter($gameCharacter);
                $manager->persist($child);
                $gameCharacter->addCharacterSkill($child);
            }
            $gameCharacter->setGame($this->getGame());
            $manager->persist($gameCharacter);
            $this->getGame()->addGameCharacter($gameCharacter);

            //Flush and return
            $manager->flush();
            $this->addFlash("success", "Skills have been updated");
            return $this->redirectToRoute('gameBack_characterSheet', ['game' => $this->getGame()->getId(), 'gameCharacter' => $gameCharacter->getId()]);

        }

        //Render page
        return $this->render('back/character-manager/skills.html.twig', [
            'form' => $form->createView(),
            'character' => $gameCharacter,
        ]);
    }


    /**
     * @Route("/{gameCharacter}/inventory", name="gameBack_characterManager_inventory")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param GameCharacter|null $gameCharacter
     * @return Response
     */
    public function inventory(EntityManagerInterface $manager, Request $request, ?GameCharacter $gameCharacter)
    {
        $this->checkEntityGameContext($gameCharacter);

        //Create form and handle request
        $form = $this->createForm(CharacterInventoryType::class, $gameCharacter);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            //Persist inventory
            foreach($gameCharacter->getInventoryItems() as $child) {
                $child->setGameCharacter($gameCharacter); $manager->persist($child);
            }
            foreach($gameCharacter->getInventoryConsumables() as $child) {
                $child->setGameCharacter($gameCharacter); $manager->persist($child);
            }
            foreach($gameCharacter->getInventoryWeapons() as $child) {
                $child->setGameCharacter($gameCharacter); $manager->persist($child);
            }
            foreach($gameCharacter->getInventoryGears() as $child) {
                $child->setGameCharacter($gameCharacter); $manager->persist($child);
            }
            foreach($gameCharacter->getCharacterJobs() as $child) {
                $child->setGameCharacter($gameCharacter); $manager->persist($child);
            }

            //Persist character
            $gameCharacter->setGame($this->getGame());
            $manager->persist($gameCharacter);
            $this->getGame()->addGameCharacter($gameCharacter);

            //Flush
            $manager->flush();
            $this->addFlash("success", "Inventory have been updated");
            return $this->redirectToRoute('gameBack_characterSheet', ['game' => $this->getGame()->getId(), 'gameCharacter' => $gameCharacter->getId()]);

        }

        //Render page
        return $this->render('back/character-manager/inventory.html.twig', [
            'form' => $form->createView(),
            'character' => $gameCharacter,
        ]);
    }

    /**
     * @Route("/{gameCharacter}/characteristics", name="gameBack_characterManager_characteristics")
     * @param GameCharacter $gameCharacter
     * @param CharacteristicsManager $characteristicsManager
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function characteristics(GameCharacter $gameCharacter, CharacteristicsManager $characteristicsManager, EntityManagerInterface $manager)
    {

        $characteristicsManager->initData($gameCharacter);
        $characteristicsManager->handleCharacteristicsPost($_POST, $gameCharacter);

        //If posted, check and flush
        if(isset($_POST["character_resources"]) || isset($_POST["character_attributes"])) {
            $manager->persist($gameCharacter);
            $manager->flush();
            $this->addFlash("success", "Characteristics have been updated");
            return $this->redirectToRoute('gameBack_characterSheet', ['game' => $this->getGame()->getId(), 'gameCharacter' => $gameCharacter->getId()]);
        }

        return $this->render('back/character-manager/characteristics.html.twig', [
            'character' => $gameCharacter
        ]);
    }

    /**
     * @Route("/{gameCharacter}/identity", name="gameBack_characterManager_identity")
     * @param GameCharacter|null $gameCharacter
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param CharacteristicsManager $characteristicsManager
     * @return Response
     */
    public function identity(GameCharacter $gameCharacter, EntityManagerInterface $manager, Request $request, CharacteristicsManager $characteristicsManager)
    {
        $this->checkEntityGameContext($gameCharacter);

        //Create form and handle request
        $form = $this->createForm(CharacterIdentityType::class, $gameCharacter);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            //Persist passives
            foreach($gameCharacter->getCharacterPassives() as $child) {
                $child->setGameCharacter($gameCharacter);
                $manager->persist($child);
                $gameCharacter->addCharacterPassive($child);
            }

            //Persist status effects
            foreach($gameCharacter->getCharacterStatusEffects() as $child) {
                $child->setGameCharacter($gameCharacter);
                $manager->persist($child);
                $gameCharacter->addCharacterStatusEffect($child);
            }

            //Persist character
            $gameCharacter->setGame($this->getGame());
            $manager->persist($gameCharacter);
            $this->getGame()->addGameCharacter($gameCharacter);

            //Flush
            $characteristicsManager->calculateCharacteristics($gameCharacter);
            $manager->flush();
            $this->addFlash("success", "Status have been updated");
            return $this->redirectToRoute('gameBack_characterSheet', ['game' => $this->getGame()->getId(), 'gameCharacter' => $gameCharacter->getId()]);

        }

        //Render page
        return $this->render('back/character-manager/identity.html.twig', [
            'form' => $form->createView(),
            'character' => $gameCharacter,
        ]);


    }


}
