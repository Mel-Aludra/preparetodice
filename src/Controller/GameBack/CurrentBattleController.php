<?php

namespace App\Controller\GameBack;

use App\Entity\InventoryConsumable;
use App\Entity\InventoryWeapon;
use App\Service\Battle\ActionService;
use App\Entity\Action;
use App\Entity\CharacterSkill;
use App\Repository\GameCharacterRepository;
use App\Service\Battle\StatusEffectApplierService;
use App\Service\GameEnv;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class BattleController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/current-battle")
 */
class CurrentBattleController extends Controller
{

    public function __construct(GameEnv $gameEnv, Environment $twigEnv)
    {
        parent::__construct($gameEnv, $twigEnv);
        if($this->getGame()->getCurrentBattle() === null)
            throw new AccessDeniedHttpException("There is no current battle, you can't reach this page.");
    }

    /**
     * @Route("/", name="gameBack_currentBattle_overview")
     * @param GameCharacterRepository $characterRepository
     * @return Response
     */
    public function overview(GameCharacterRepository $characterRepository)
    {
        return $this->render('back/current-battle/overview.html.twig', [
            'battle' => $this->getGame()->getCurrentBattle(),
            'teams' => ["allies" => $characterRepository->findBy(["game" => $this->getGame()->getId(), "team" => "allies"]), "foes" => $characterRepository->findBy(["game" => $this->getGame()->getId(), "team" => "foes"])]
        ]);
    }

    /**
     * @Route("/skill-to-action/{characterSkill}/{skipUpdate}", name="gameBack_currentBattle_skillToAction")
     * @param CharacterSkill $characterSkill
     * @param string $skipUpdate
     * @param EntityManagerInterface $manager
     * @param ActionService $actionService
     * @return Response
     */
    public function skillToAction(CharacterSkill $characterSkill, string $skipUpdate, EntityManagerInterface $manager, ActionService $actionService)
    {
        $action = new Action();
        $actionService->hydrateAction($characterSkill, $characterSkill->getSkill(), $action);
        if($skipUpdate === "false")
            return $this->redirectToRoute('gameBack_currentBattle_updateAction', ['game' => $this->getGame()->getId(), 'action' => $action->getId()]);
        return $this->redirectToRoute('gameBack_currentBattle_selectTargets', ['game' => $this->getGame()->getId(), 'action' => $action->getId()]);
    }

    /**
     * @Route("/consumable-to-action/{inventoryConsumable}/{skipUpdate}", name="gameBack_currentBattle_consumableToAction")
     * @param InventoryConsumable $inventoryConsumable
     * @param string $skipUpdate
     * @param EntityManagerInterface $manager
     * @param ActionService $actionService
     * @return Response
     */
    public function consumableToAction(InventoryConsumable $inventoryConsumable, string $skipUpdate, EntityManagerInterface $manager, ActionService $actionService)
    {
        $action = new Action();
        $actionService->hydrateAction($inventoryConsumable, $inventoryConsumable->getConsumable(), $action);
        if($skipUpdate === "false")
            return $this->redirectToRoute('gameBack_currentBattle_updateAction', ['game' => $this->getGame()->getId(), 'action' => $action->getId()]);
        return $this->redirectToRoute('gameBack_currentBattle_selectTargets', ['game' => $this->getGame()->getId(), 'action' => $action->getId()]);
    }

    /**
     * @Route("/weapon-to-action/{inventoryWeapon}/{skipUpdate}", name="gameBack_currentBattle_weaponToAction")
     * @param inventoryWeapon $inventoryWeapon
     * @param string $skipUpdate
     * @param EntityManagerInterface $manager
     * @param ActionService $actionService
     * @return Response
     */
    public function inventoryToAction(InventoryWeapon $inventoryWeapon, string $skipUpdate, EntityManagerInterface $manager, ActionService $actionService)
    {
        $action = new Action();
        $actionService->hydrateAction($inventoryWeapon, $inventoryWeapon->getWeapon(), $action);
        if($skipUpdate === "false")
            return $this->redirectToRoute('gameBack_currentBattle_updateAction', ['game' => $this->getGame()->getId(), 'action' => $action->getId()]);
        return $this->redirectToRoute('gameBack_currentBattle_selectTargets', ['game' => $this->getGame()->getId(), 'action' => $action->getId()]);
    }

    /**
     * @Route("/finish-turn", name="gameBack_currentBattle_finishTurn")
     * @param EntityManagerInterface $manager
     * @param StatusEffectApplierService $statusEffectApplierService
     * @return Response
     */
    public function finishTurn(EntityManagerInterface $manager, StatusEffectApplierService $statusEffectApplierService)
    {
        $this->getGame()->getCurrentBattle()->setTurnsNumber($this->getGame()->getCurrentBattle()->getTurnsNumber() + 1);
        $statusEffectApplierService->finishTurnStatusEffectsApplier();
        $manager->persist($this->getGame()->getCurrentBattle());
        $manager->flush();
        $this->addFlash("success", "Turn " . $this->getGame()->getCurrentBattle()->getTurnsNumber() . " start!");
        return $this->redirectToRoute('gameBack_currentBattle_overview', ["game" => $this->getGame()->getId()]);
    }

    /**
     * @Route("/end-battle", name="gameBack_currentBattle_endBattle")
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function endBattle(EntityManagerInterface $manager)
    {
        $this->getGame()->setCurrentBattle(null);
        $manager->persist($this->getGame());
        $manager->flush();
        return $this->redirectToRoute('gameBack_battle_list', ["game" => $this->getGame()->getId()]);
    }

}
