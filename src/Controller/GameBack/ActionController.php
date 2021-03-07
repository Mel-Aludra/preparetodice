<?php

namespace App\Controller\GameBack;

use App\Service\Battle\ActionService;
use App\Service\Battle\ActionToLogService;
use App\Entity\Action;
use App\Form\GameBack\ActionType;
use App\Repository\GameCharacterRepository;
use App\Service\Battle\TargetsService;
use App\Service\GameEnv;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class ActionController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/current-battle")
 */
class ActionController extends Controller
{

    public function __construct(GameEnv $gameEnv, Environment $twigEnv)
    {
        parent::__construct($gameEnv, $twigEnv);
        if($this->getGame()->getCurrentBattle() === null)
            throw new AccessDeniedHttpException("There is no current battle, you can't reach this page.");
    }

    private function actionIntegrityChecker(Action $action)
    {
        parent::checkEntityGameContext($action->getBattle());
        if($action->getHasBeenLaunched()) {
            $this->addFlash('error', "Action " . $action->getName() . " have already been launched.");
            return $this->redirectToRoute('gameBack_currentBattle_overview', [
                "game" => $this->getGame()->getId()
            ]);
        }
    }

    /**
     * @Route("/add-action", name="gameBack_currentBattle_addAction")
     * @Route("/update-action/{action}", name="gameBack_currentBattle_updateAction")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Action|null $action
     * @return Response
     */
    public function addAndUpdate(EntityManagerInterface $manager, Request $request, ?Action $action)
    {
        if($action !== null) {
            $this->actionIntegrityChecker($action);
        } else {
            $action = new Action();
        }

        //Create form and handle request
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            //We persist action
            $action->setBattle($this->getGame()->getCurrentBattle());
            $manager->persist($action);
            $this->getGame()->getCurrentBattle()->addAction($action);

            //We add costs, gains, damages, heal and se
            foreach($action->getSkillCosts() as $cost) {
                $cost->setAction($action); $manager->persist($cost); $action->addSkillCost($cost);
            }
            foreach($action->getSkillGains() as $gain) {
                $gain->setAction($action); $manager->persist($gain); $action->addSkillGain($gain);
            }
            foreach($action->getSkillDamageEffects() as $effect) {
                $effect->setAction($action); $manager->persist($effect); $action->addSkillDamageEffect($effect);
                foreach($effect->getPotencyAugmentator() as $augmentator) {
                    $augmentator->addSkillDamageEffect($effect);
                    $manager->persist($augmentator);
                }
            }
            foreach($action->getSkillHealEffects() as $effect) {
                $effect->setAction($action); $manager->persist($effect); $action->addSkillHealEffect($effect);
                foreach($effect->getPotencyAugmentator() as $augmentator) {
                    $augmentator->addSkillHealEffect($effect);
                    $manager->persist($augmentator);
                }
            }
            foreach($action->getSkillStatusEffects() as $effect) {
                $effect->setAction($action); $manager->persist($effect); $action->addSkillStatusEffect($effect);
            }

            //Flush, flash and redirect
            $manager->flush();
            $this->addFlash("neutral", "Now, select targets!");
            return $this->redirectToRoute('gameBack_currentBattle_selectTargets', ['game' => $this->getGame()->getId(), 'action' => $action->getId()]);
        }

        //Render page
        return $this->render('back/current-battle/edit-action.html.twig', [
            'form' => $form->createView(),
            'action' => $action,
            'battle' => $this->getGame()->getCurrentBattle()
        ]);
    }

    /**
     * @Route("/select-targets/{action}", name="gameBack_currentBattle_selectTargets")
     * @param Action $action
     * @param EntityManagerInterface $manager
     * @param GameCharacterRepository $characterRepository
     * @param TargetsService $targetsService
     * @return Response
     */
    public function selectTargets(Action $action, EntityManagerInterface $manager, GameCharacterRepository $characterRepository, TargetsService $targetsService)
    {
        $this->actionIntegrityChecker($action);

        //Allies and foes for targeting
        $allies = $characterRepository->findBy(["game" => $this->getGame()->getId(), "team" => "allies"]);
        $foes = $characterRepository->findBy(["game" => $this->getGame()->getId(), "team" => "foes"]);

        //If targets are posted, we parse action for add targets
        if(isset($_POST["selectTargets"])) {
            $activeCharacters = array_merge($allies, $foes);
            $targetsService->wipeTargets($action); //wipe targets before set new ones
            $targetsService->handleTargetsPost($action, $activeCharacters, $_POST["selectTargets"]);
            $this->addFlash("neutral", "Now, preview skill, roll dices and launch action!");
            return $this->redirectToRoute('gameBack_currentBattle_previewAction', ['game' => $this->getGame()->getId(), 'action' => $action->getId()]);
        }

        //Return view
        return $this->render('back/current-battle/select-targets.html.twig', [
            'battle' => $this->getGame()->getCurrentBattle(),
            'action' => $action,
            'teams' => ["allies" => $allies, "foes" => $foes]
        ]);
    }

    /**
     * @Route("/action-preview/{action}", name="gameBack_currentBattle_previewAction")
     * @param Action $action
     * @param EntityManagerInterface $manager
     * @param ActionToLogService $actionToLogService
     * @return Response
     */
    public function actionPreview(Action $action, EntityManagerInterface $manager, ActionToLogService $actionToLogService)
    {
        $this->actionIntegrityChecker($action);

        //For each target on each effect, we ask to the action to log service to transform into logs
        $actionToLogService->actionToLogs($action);
        $manager->flush();

        //Return view
        return $this->render('back/current-battle/preview-action.html.twig', [
            'battle' => $this->getGame()->getCurrentBattle(),
            'action' => $action,
            'logs' => $action->getSortedLogs()
        ]);
    }

    /**
     * @Route("/action-preview/launch/{action}", name="gameBack_currentBattle_launchAction")
     * @param Action $action
     * @param EntityManagerInterface $manager
     * @param ActionService $actionService
     * @return Response
     */
    public function launchAction(Action $action, EntityManagerInterface $manager, ActionService $actionService)
    {
        //Check integrity and apply action
        $this->actionIntegrityChecker($action);
        $actionService->applyAction($action);
        $actionService->checkAndFlush();

        //Then we destroy action (no use anymore)
        $manager->remove($action);
        $manager->flush();

        //Flash and return
        $this->addFlash('success', "Action " . $action->getName() . " have been launched!");
        return $this->redirectToRoute('gameBack_currentBattle_overview', [
            "game" => $this->getGame()->getId()
        ]);
    }

}
