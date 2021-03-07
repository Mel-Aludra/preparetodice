<?php

namespace App\Controller\GameBack;

use App\Entity\GameCharacter;
use App\Form\GameBack\EntitiesFilterType;
use App\Form\GameBack\GameCharacterType;
use App\Repository\GameCharacterRepository;
use App\Service\CharacteristicsManager;
use App\Service\EntitiesFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameCharacterController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/character")
 */
class GameCharacterController extends Controller
{
    /**
     * @Route("/list/{page<\d+>?1}", name="gameBack_character_list")
     * @param GameCharacterRepository $repo
     * @param int $page
     * @param Request $request
     * @return Response
     */
    public function list(GameCharacterRepository $repo, int $page, Request $request)
    {
        //Manage paging with filters and ordering post
        $entitiesFiltersForm = $this->createForm(EntitiesFilterType::class, null, [
            "filtersElements" => ["name", "description"],
            "sortingElements" => ["id", "name"]
        ]);
        $entitiesFiltersService = new EntitiesFilterService($repo, $page, 'gameBack_character_list', $this->getGame(), $entitiesFiltersForm, $request);

        //Return view
        return $this->render('back/game-character/list.html.twig', [
            'characters' => $entitiesFiltersService->getEntities(),
            'entitiesFiltersService' => $entitiesFiltersService->createView()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_character_add")
     * @Route("/update/{gameCharacter}", name="gameBack_character_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param GameCharacter|null $gameCharacter
     * @param CharacteristicsManager $characteristicsManager
     * @return Response
     */
    public function addAndUpdateGameCharacter(EntityManagerInterface $manager, Request $request, ?GameCharacter $gameCharacter, CharacteristicsManager $characteristicsManager)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $gameCharacter = new GameCharacter();
        else
            $this->checkEntityGameContext($gameCharacter);

        //Init character data
        $characteristicsManager->initData($gameCharacter);

        //Create form and handle request
        $form = $this->createForm(GameCharacterType::class, $gameCharacter);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            //Persist skills
            foreach($gameCharacter->getCharacterSkills() as $child) {
                $child->setGameCharacter($gameCharacter);
                $manager->persist($child);
                $gameCharacter->addCharacterSkill($child);
            }

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

            //Handle resources
            foreach($gameCharacter->getCharacterResources() as $child) { $manager->persist($child); }
            foreach($gameCharacter->getCharacterAttributes() as $child) { $manager->persist($child); }

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

            //Story
            foreach($gameCharacter->getCharacterStories() as $child) {
                $child->setGameCharacter($gameCharacter); $manager->persist($child);
            }

            //Persist character
            $gameCharacter->setGame($this->getGame());
            $manager->persist($gameCharacter);
            $this->getGame()->addGameCharacter($gameCharacter);

            //Characteristics post
            $characteristicsManager->handleCharacteristicsPost($_POST, $gameCharacter);

            //Flush
            $manager->flush();

            //We return message and redirection
            $message = "Character " . $gameCharacter->getName() . " have been created.";
            if($context == "update")
                $message = "Character " . $gameCharacter->getName() . " have been updated.";
            $this->addFlash("success", $message);
            return $this->redirectToRoute('gameBack_character_list', ['game' => $this->getGame()->getId()]);

        }

        //Render page
        return $this->render('back/game-character/edit.html.twig', [
            'form' => $form->createView(),
            'character' => $gameCharacter,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{gameCharacter}", name="gameBack_character_delete")
     * @param EntityManagerInterface $manager
     * @param GameCharacter|null $gameCharacter
     * @return Response
     */
    public function delete(GameCharacter $gameCharacter, EntityManagerInterface $manager)
    {
        $manager->remove($gameCharacter);
        $manager->flush();
        $this->addFlash("success", "Character " . $gameCharacter->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_character_list', ['game' => $this->getGame()->getId()]);
    }

}
