<?php

namespace App\Controller\Front;

use App\Entity\Entity;
use App\Entity\Game;
use App\Entity\Invitation;
use App\Entity\UserGame;
use App\Form\Front\GameType;
use App\Service\HydrateGameService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    /**
     * @Route("/game/add", name="front_game_add")
     * @IsGranted("ROLE_USER")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param HydrateGameService $hydrateGameService
     * @return Response
     */
    public function addGame(EntityManagerInterface $manager, Request $request, HydrateGameService $hydrateGameService)
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $userGame = new UserGame();
            $userGame->setGame($game);
            $userGame->setUser($this->getUser());
            $userGame->setAccessType(UserGame::OWNER_ACCESS);
            $manager->persist($game);
            $this->getUser()->addUserGame($userGame);
            $manager->persist($userGame);
            $manager->flush();
            $hydrateGameService->basicGameHydratation($game);
            return $this->redirectToRoute('front_game_list');
        }

        return $this->render('front/game/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/game/list", name="front_game_list")
     * @return Response
     */
    public function listGames()
    {
        return $this->render('front/game/list.html.twig', [
            "userGames" => $this->getUser()->getUserGames()
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/game/invitation/{invitation}/accept", name="front_invitation_accept")
     * @param EntityManagerInterface $manager
     * @param Invitation $invitation
     * @return Response
     */
    public function acceptInvitation(EntityManagerInterface $manager, Invitation $invitation)
    {
        //Check if invitation belong to user
        if($invitation->getUser()->getId() === $this->getUser()->getId()) {

            $userGame = new UserGame();
            $userGame->setAccessType($invitation->getAccessType());
            $userGame->setGame($invitation->getGame());
            $userGame->setUser($this->getUser());
            $this->getUser()->addUserGame($userGame);
            $manager->persist($userGame);
            $manager->remove($invitation);
            $manager->flush();
            $this->addFlash("success", "You're now part of the game " . $invitation->getGame()->getName() . "!");

        } else {
            $this->addFlash("error", "This link doesn't exists");
        }

        return $this->redirectToRoute('front_game_list');

    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/game/invitation/{invitation}/decline", name="front_invitation_decline")
     * @param EntityManagerInterface $manager
     * @param Invitation $invitation
     * @return Response
     */
    public function declineInvitation(EntityManagerInterface $manager, Invitation $invitation)
    {
        //Check if invitation belong to user
        if($invitation->getUser()->getId() === $this->getUser()->getId()) {
            $manager->remove($invitation);
            $manager->flush();
            $this->addFlash("success", "You declined the invitation");

        } else
            $this->addFlash("error", "This link doesn't exists");

        return $this->redirectToRoute('front_game_list');

    }

}
