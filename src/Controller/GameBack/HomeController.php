<?php

namespace App\Controller\GameBack;
use App\Entity\GameCharacter;
use App\Entity\InventoryConsumable;
use App\Entity\InventoryGear;
use App\Entity\InventoryItem;
use App\Entity\InventoryWeapon;
use App\Repository\GameCharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller\GameBack
 * @Route("/back/{game}")
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="gameBack_home")
     * @param GameCharacterRepository $gameCharacterRepo
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(GameCharacterRepository $gameCharacterRepo, EntityManagerInterface $manager)
    {

        //Manager item swap
        $this->swapItemFunction($gameCharacterRepo, $manager);

        //Teams
        $allies = $gameCharacterRepo->findBy(["game" => $this->getGame()->getId(), "team" => "allies"]);
        $foes = $gameCharacterRepo->findBy(["game" => $this->getGame()->getId(), "team" => "foes"]);

        //View
        return $this->render('back/home/home.html.twig', [
            'allies' => $allies,
            'foes' => $foes,
            'activeCharacters' => array_merge($allies, $foes)
        ]);
    }

    /**
     * @Route("/heal/{typeOfHealing}", name="gameBack_heal")
     * @param string $typeOfHealing
     * @param GameCharacterRepository $gameCharacterRepo
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function healCharacters(string $typeOfHealing, GameCharacterRepository $gameCharacterRepo, EntityManagerInterface $manager)
    {
        $characters = [];
        switch($typeOfHealing) {
            case "allies":
                $characters = $gameCharacterRepo->findBy(["game" => $this->getGame()->getId(), "team" => "allies"]);
                break;
            case "foes":
                $characters = $gameCharacterRepo->findBy(["game" => $this->getGame()->getId(), "team" => "foes"]);
                break;
            case "all":
                $characters = $this->getGame()->getGameCharacters();
                break;
        }
        /** @var GameCharacter $character */
        foreach($characters as $character) {
            foreach($character->getCharacterResources() as $characterResource) {
                $characterResource->setCurrentValue($characterResource->getFinalValue());
                $manager->persist($characterResource);
            }
        }
        $manager->flush();
        $this->addFlash("success", ucfirst($typeOfHealing) . " characters have been healed");
        return $this->redirectToRoute("gameBack_home", ["game" => $this->getGame()->getId()]);
    }

    /**
     * @param GameCharacterRepository $gameCharacterRepo
     * @param EntityManagerInterface $manager
     */
    private function swapItemFunction(GameCharacterRepository $gameCharacterRepo, EntityManagerInterface $manager)
    {
        if(isset($_POST["swapItem"])) {

            //We get concerned characters and check if they're belong to current game
            $fromCharacter = $gameCharacterRepo->find($_POST["swapItem"]["from"]);
            $toCharacter = $gameCharacterRepo->find($_POST["swapItem"]["to"]);
            if(isset($_POST["swapItem"]["itemData"]) && $fromCharacter->getGame()->getId() === $this->getGame()->getId() && $toCharacter->getGame()->getId() === $this->getGame()->getId()) {

                //We get inventory item and check if belong to character (from character)
                $itemData = explode("_", $_POST["swapItem"]["itemData"]);
                $type = $itemData[0];
                $id = $itemData[1];
                $repo = null; $addAccessor = null; $removeAccessor = null;
                switch($type) {
                    case "item":
                        $repo = $this->getDoctrine()->getRepository(InventoryItem::class);
                        $addAccessor = "addInventoryItem"; $removeAccessor = "removeInventoryItem";
                        break;
                    case "consumable":
                        $repo = $this->getDoctrine()->getRepository(InventoryConsumable::class);
                        $addAccessor = "addInventoryConsumable"; $removeAccessor = "removeInventoryConsumable";
                        break;
                    case "weapon":
                        $repo = $this->getDoctrine()->getRepository(InventoryWeapon::class);
                        $addAccessor = "addInventoryWeapon"; $removeAccessor = "removeInventoryWeapon";
                        break;
                    case "gear":
                        $repo = $this->getDoctrine()->getRepository(InventoryGear::class);
                        $addAccessor = "addInventoryGear"; $removeAccessor = "removeInventoryGear";
                        break;
                }
                if($repo !== null && $addAccessor !== null && $removeAccessor !== null) {
                    $inventory = $repo->find($id);
                    if($inventory !== null && $inventory->getGameCharacter()->getId() === $fromCharacter->getId()) {

                        //Get quantity and rationalize it
                        $quantity = 1;
                        if((int) $_POST["swapItem"]["quantity"] > 1)
                            $quantity = (int) $_POST["swapItem"]["quantity"];
                        if($quantity > $inventory->getQuantity())
                            $quantity = $inventory->getQuantity();

                        //Swap item
                        $newInventory = clone $inventory;
                        $inventory->setQuantity($inventory->getQuantity() - $quantity);
                        if($inventory->getQuantity() === 0) {
                            $fromCharacter->$removeAccessor($inventory);
                            $manager->remove($inventory);
                        }
                        $newInventory->setGameCharacter($toCharacter);
                        $newInventory->setQuantity($quantity);
                        $toCharacter->$addAccessor($newInventory);
                        $manager->persist($newInventory);
                        $manager->flush();
                        $this->addFlash("success", ucfirst($type) . " have been swap");
                    }
                }

            }

        }
    }
}
