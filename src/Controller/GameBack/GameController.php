<?php

namespace App\Controller\GameBack;

use App\Entity\Gear;
use App\Entity\Invitation;
use App\Entity\User;
use App\Entity\UserGame;
use App\Entity\UserGameCharacter;
use App\Form\Front\GameType;
use App\Form\GameBack\EntitiesFilterType;
use App\Form\GameBack\GearType;
use App\Form\GameBack\UserGameType;
use App\Repository\GearRepository;
use App\Repository\UserRepository;
use App\Service\CharacteristicsManager;
use App\Service\EntitiesFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/settings")
 */
class GameController extends Controller
{
    /**
     * @Route("/", name="gameBack_settings")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserRepository $userRepository
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function game(Request $request, EntityManagerInterface $manager, UserRepository $userRepository, MailerInterface $mailer)
    {

        //Game form
        $gameForm = $this->createForm(GameType::class, $this->getGame());
        $gameForm->handleRequest($request);
        if($gameForm->isSubmitted() && $gameForm->isValid()) {
            $manager->persist($this->getGame());
            $manager->flush();
            $this->addFlash("success", "Game have been updated");
        }

        //Invitations
        if(isset($_POST["invitation"])) {

            $user = null;
            if(isset($_POST["invitation"]["email"]))
                $user = $userRepository->findOneBy(["email" => $_POST["invitation"]["email"]]);
            if($user !== null) {
                $invitation = new Invitation();
                $invitation->setGame($this->getGame());
                $invitation->setUser($user);
                $invitation->setAccessType(UserGame::PLAYER_ACCESS);
                if(isset($_POST["invitation"]["accessType"]) && $_POST["invitation"]["accessType"] === UserGame::GM_ACCESS)
                    $invitation->setAccessType(UserGame::GM_ACCESS);
                $this->getGame()->addInvitation($invitation);

                //Send mail
                $email = new TemplatedEmail();
                $email->from("contact@morbol.fr")
                    ->to($invitation->getUser()->getEmail())
                    ->subject("[Preparetodice] - Invitation to game " . $invitation->getGame()->getName())
                    ->htmlTemplate('mails/invitation.html.twig')
                    ->context(['invitation' => $invitation]);
                $mailer->send($email);

                $manager->persist($invitation);
                $manager->flush();
                $this->addFlash("success", "User has been invited");
            } else {
                $this->addFlash("error", "User was not found");
            }

        }

        //Return view
        return $this->render('back/game/settings.html.twig', [
            'gameForm' => $gameForm->createView()
        ]);
    }

    /**
     * @Route("/characters/{userGame}", name="gameBack_settings_characters")
     * @param UserGame $userGame
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserRepository $userRepository
     * @return Response
     */
    public function manageCharacters(UserGame $userGame, Request $request, EntityManagerInterface $manager, UserRepository $userRepository)
    {

        //Game form
        $form = $this->createForm(UserGameType::class, $userGame);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            foreach($userGame->getUserGameCharacters() as $userGameCharacter) {
                $userGameCharacter->setUserGame($userGame);
                $userGameCharacter->setAccessType(UserGameCharacter::READ_ACCESS);
                $manager->persist($userGameCharacter);
            }
            $manager->persist($userGame);
            $manager->flush();
            $this->addFlash("success", "User characters have been updated");
            return $this->redirectToRoute('gameBack_settings', ['game' => $this->getGame()->getId()]);
        }

        //Return view
        return $this->render('back/game/user-game.html.twig', [
            'form' => $form->createView(),
            'userGame' => $userGame
        ]);

    }



}
