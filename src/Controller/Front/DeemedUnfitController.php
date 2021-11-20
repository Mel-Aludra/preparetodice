<?php

namespace App\Controller\Front;

use App\Entity\Game;
use App\Entity\UserGame;
use App\Form\Front\GameType;
use App\Service\HydrateGameService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeemedUnfitController extends AbstractController
{

    /**
     * @Route("/deemed-unfit", name="front_deemedUnfit")
     * @return Response
     */
    public function deemedUnfit()
    {

        return $this->render('front/custom-games/deemed-unfit.html.twig', []);
    }

    /**
     * @Route("/deemed-unfit/add", name="front_deemedUnfit_add")
     * @IsGranted("ROLE_USER")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param HydrateGameService $hydrateGameService
     * @return Response
     */
    public function addGame(EntityManagerInterface $manager, Request $request, HydrateGameService $hydrateGameService)
    {
        $game = new Game();
        $game->setMoneyTerm("Argent");
        $game->setName("Deemed Unfit");
        $game->setDescription("...");
        $game->setIsActive(1);
        $game->setBackground("img_cosmos");
        $hydrateGameService->deemedUnfitHydratation($game);
        $userGame = new UserGame();
        $userGame->setGame($game);
        $userGame->setUser($this->getUser());
        $userGame->setAccessType(UserGame::OWNER_ACCESS);
        $manager->persist($game);
        $this->getUser()->addUserGame($userGame);
        $manager->persist($userGame);
        $manager->flush();
        $this->addFlash("success", "Votre jeu Deemed Unfit a bien été créé. Retrouvez-le sur cette page.");
        return $this->redirectToRoute('front_game_list');
    }

}
