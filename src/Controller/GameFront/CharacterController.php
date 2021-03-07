<?php

namespace App\Controller\GameFront;

use App\Entity\GameCharacter;
use App\Repository\GameCharacterRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CharacterSheetController
 * @package App\Controller\GameFront
 * @Route("/game/{game}")
 */
class CharacterController extends Controller
{

    /**
     * @Route("/characters", name="gameFront_characters")
     * @return Response
     */
    public function list()
    {
        return $this->render('front/game-character/list.html.twig', [
            'characters' => $this->getUser()->getGameCharacters($this->getGame())
        ]);
    }

    /**
     * @Route("/character/{gameCharacter}", name="gameFront_character")
     * @param GameCharacter $gameCharacter
     * @return Response
     */
    public function characterSheet(GameCharacter $gameCharacter)
    {
        return $this->render('front/game-character/game-character.html.twig', [
            'character' => $gameCharacter
        ]);
    }

    /**
     * @param GameCharacter $character
     * @param Request $request
     * @param GameCharacterRepository $repo
     * @return Response
     * @Route("/ajax-character/{character}", name="ajaxCharacter_content")
     */
    public function ajaxAction(GameCharacter $character, Request $request, GameCharacterRepository $repo)
    {

        $tab = $request->request->get('tab');

        $template = "";

        switch($tab) {

            case "status":
                $template = $this->renderView('front/game-character/content-status.html.twig', [
                    'character' => $character
                ]);
                break;

            case "skills":
                $template = $this->renderView('front/game-character/content-skills.html.twig', [
                    'character' => $character
                ]);
                break;

            case "inventory":
                $template = $this->renderView('front/game-character/content-inventory.html.twig', [
                    'character' => $character
                ]);
                break;

            case "battle":
                $characterRepository = $this->getDoctrine()->getRepository(GameCharacter::class);
                $battle = $this->getGame()->getCurrentBattle();
                $partOfBattle = false;
                if($character->getTeam() !== null)
                    $partOfBattle = true;
                $template = $this->renderView('front/game-character/content-battle.html.twig', [
                    'character' => $character,
                    'partOfBattle' => $partOfBattle,
                    'battle' => $battle,
                    'allies' => $characterRepository->findBy(["game" => $this->getGame()->getId(), "team" => "allies"]),
                    'foes' => $characterRepository->findBy(["game" => $this->getGame()->getId(), "team" => "foes"])
                ]);
                break;



        }

        $response = new Response(json_encode(array(
            'response' => $template
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
