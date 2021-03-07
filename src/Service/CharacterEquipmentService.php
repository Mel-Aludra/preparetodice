<?php

namespace App\Service;

use App\Entity\EquipmentSlot;
use App\Entity\EquippedGear;
use App\Entity\Game;
use App\Entity\GameCharacter;
use App\Entity\InventoryGear;
use App\Entity\InventoryWeapon;
use Doctrine\ORM\EntityManagerInterface;

class CharacterEquipmentService
{

    private Game $game;
    private EntityManagerInterface $manager;

    /**
     * @param GameEnv $gameEnv
     * @param EntityManagerInterface $manager
     */
    public function __construct(GameEnv $gameEnv, EntityManagerInterface $manager)
    {
        $this->game = $gameEnv->getGame();
        $this->manager = $manager;
    }

    public function getGame() :Game { return $this->game; }

    /**
     * @param GameCharacter $character
     * @param EquipmentSlot $equipmentSlot
     * @return null|EquippedGear
     */
    public function getCharacterEquippedGearFromSlot(GameCharacter $character, EquipmentSlot $equipmentSlot) :?EquippedGear
    {
        //Looking for equipped gear
        $foundEquippedGear = null;
        foreach($character->getEquippedGears() as $equippedGear) {
            if($equippedGear->getEquipmentSlot()->getId() === $equipmentSlot->getId())
                $foundEquippedGear = $equippedGear;
        }

        //We return it
        return $foundEquippedGear;
    }

    /**
     * @param GameCharacter $character
     * @param $inventoryWeaponId
     * @return InventoryWeapon|null
     */
    public function getInventoryWeaponFromId(GameCharacter $character, $inventoryWeaponId) :?InventoryWeapon
    {
        foreach($character->getInventoryWeapons() as $inventoryWeapon) {
            if((int) $inventoryWeapon->getId() === (int) $inventoryWeaponId)
                return $inventoryWeapon;
        }
        return null;
    }

    /**
     * @param GameCharacter $character
     * @param $inventoryGearId
     * @return InventoryWeapon|null
     */
    public function getInventoryGearFromId(GameCharacter $character, $inventoryGearId) :?InventoryGear
    {
        foreach($character->getInventoryGears() as $inventoryGear) {
            if((int) $inventoryGear->getId() === (int) $inventoryGearId)
                return $inventoryGear;
        }
        return null;
    }

}