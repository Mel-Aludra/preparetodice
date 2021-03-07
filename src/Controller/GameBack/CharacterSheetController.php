<?php

namespace App\Controller\GameBack;

use App\Entity\GameCharacter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameCharacterController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/character-sheet")
 */
class CharacterSheetController extends Controller
{

    /**
     * @Route("/{gameCharacter}", name="gameBack_characterSheet")
     * @param GameCharacter|null $gameCharacter
     * @return Response
     */
    public function characterSheet(GameCharacter $gameCharacter)
    {
        return $this->render('back/character-sheet/character-sheet.html.twig', [
            'character' => $gameCharacter,
        ]);
    }

}
