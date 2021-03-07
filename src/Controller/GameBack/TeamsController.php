<?php

namespace App\Controller\GameBack;

use App\Entity\GameCharacter;
use App\Repository\GameCharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TeamsController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/teams")
 */
class TeamsController extends Controller
{
    /**
     * @Route("/", name="gameBack_teams_dashboard")
     * @param GameCharacterRepository $characterRepository
     * @return Response
     */
    public function index(GameCharacterRepository $characterRepository)
    {
        //Get allies and foes
        $allies = $characterRepository->findBy(["game" => $this->getGame()->getId(), "team" => "allies"]);
        $foes = $characterRepository->findBy(["game" => $this->getGame()->getId(), "team" => "foes"]);

        //Get view
        return $this->render('back/teams/dashboard.html.twig', [
            'teams' => ["allies" => $allies, "foes" => $foes]
        ]);
    }

    /**
     * @Route("/edit", name="gameBack_teams_edit")
     * @param GameCharacterRepository $characterRepository
     * @return Response
     */
    public function edit(GameCharacterRepository $characterRepository, EntityManagerInterface $manager)
    {
        //We get characters
        $characters = $characterRepository->findBy(["game" => $this->getGame()->getId()], ["team" => "DESC"]);

        //Case of post
        if(isset($_POST["teams"])) {

            //We check for each character in game if a team is defined and apply it
            foreach($characters as $character) {
                if(isset($_POST["teams"][$character->getId()])) {
                    $character->setTeam(null);
                    if(in_array($_POST["teams"][$character->getId()], [GameCharacter::TEAM_FOES, GameCharacter::TEAM_ALLIES])) {
                        $character->setTeam($_POST["teams"][$character->getId()]);
                    }
                }
                $manager->persist($character);
            }

            //We flush, flash and redirect on teams dashboard
            $manager->flush();
            $this->addFlash("success", "Teams have been updated.");
            return $this->redirectToRoute("gameBack_teams_dashboard", ["game" => $this->getGame()->getId()]);
        }

        //Get view
        return $this->render('back/teams/edit.html.twig', [
            'characters' => $characters
        ]);
    }
}
