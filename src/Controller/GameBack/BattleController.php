<?php

namespace App\Controller\GameBack;

use App\Entity\Battle;
use App\Entity\GameCharacter;
use App\Form\GameBack\BattleType;
use App\Form\GameBack\EntitiesFilterType;
use App\Repository\BattleRepository;
use App\Repository\GameCharacterRepository;
use App\Service\EntitiesFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BattleController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/battle")
 */
class BattleController extends Controller
{
    /**
     * @Route("/list/{page<\d+>?1}", name="gameBack_battle_list")
     * @param BattleRepository $repo
     * @param int $page
     * @param Request $request
     * @return Response
     */
    public function list(BattleRepository $repo, int $page, Request $request)
    {
        //If a battle is launched, we redirect on it
        if($this->getGame()->getCurrentBattle() !== null) {
            return $this->redirectToRoute('gameBack_currentBattle_overview', ['game' => $this->getGame()->getId()]);
        }

        //Manage paging with filters and ordering post
        $entitiesFiltersForm = $this->createForm(EntitiesFilterType::class, null, [
            "filtersElements" => ["name", "description"],
            "sortingElements" => ["id", "name"]
        ]);
        $entitiesFiltersService = new EntitiesFilterService($repo, $page, 'gameBack_battle_list', $this->getGame(), $entitiesFiltersForm, $request);

        //Return view
        return $this->render('back/battle/list.html.twig', [
            'battles' => $entitiesFiltersService->getEntities(),
            'entitiesFiltersService' => $entitiesFiltersService->createView()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_battle_add")
     * @Route("/update/{battle}", name="gameBack_battle_update")
     * @param EntityManagerInterface $manager
     * @param Request                $request
     * @param Battle|null            $battle
     *
     * @return Response
     */
    public function addAndUpdateItem(EntityManagerInterface $manager, Request $request, ?Battle $battle)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add") {
            $battle = new Battle();
            $battle->setTurnsNumber(1);
        }
        else {
            $this->checkEntityGameContext($battle);
        }

        //Create form and handle request
        $form = $this->createForm(BattleType::class, $battle);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $battle->setGame($this->getGame());
            $manager->persist($battle);
            $this->getGame()->addBattle($battle);

            //Flush and flash
            $manager->flush();
            $message = "Battle " . $battle->getName() . " have been created.";
            if($context == "update")
                $message = "Battle " . $battle->getName() . " have been updated.";
            $this->addFlash("success", $message);

            return $this->redirectToRoute('gameBack_battle_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/battle/edit.html.twig', [
            'form' => $form->createView(),
            'battle' => $battle,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{battle}", name="gameBack_battle_delete")
     * @param EntityManagerInterface $manager
     * @param Battle|null $battle
     * @return Response
     */
    public function delete(Battle $battle, EntityManagerInterface $manager)
    {
        foreach($battle->getBattleLogs() as $log) {
            $manager->remove($log);
        }
        $manager->remove($battle);
        $manager->flush();
        $this->addFlash("success", "Battle " . $battle->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_battle_list', ['game' => $this->getGame()->getId()]);
    }

    /**
     * @Route("/define/{battle}", name="gameBack_battle_define")
     * @param Battle|null $battle
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function defineCurrentBattle(Battle $battle, EntityManagerInterface $manager)
    {
        if($battle->getGame()->getId() === $this->getGame()->getId()) {
            $this->getGame()->setCurrentBattle($battle);
            $manager->persist($this->getGame());
            $manager->flush();
            $this->addFlash("success", "Battle " . $battle->getName() . " is launched!");
            return $this->redirectToRoute('gameBack_currentBattle_overview', ["game" => $this->getGame()->getId()]);
        }
        $this->addFlash("error", "An error occured while launch battle.");
        return $this->redirectToRoute('gameBack_battle_list', ["game" => $this->getGame()->getId()]);
    }

}
