<?php

namespace App\Controller\GameFront;

use App\Entity\LoreBlock;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller\GameFront
 * @Route("/game/{game}")
 */
class HomeController extends Controller
{

    /**
     * @Route("/", name="gameFront_home")
     * @return Response
     */
    public function home()
    {

        //We get game public elements that is not related to some tags
        $neutralLoreBlocks = [];
        foreach($this->getGame()->getLoreBlocks() as $loreBlock) {
            if($loreBlock->getTag() === null) {
                if($loreBlock->getAccessType() === LoreBlock::PUBLIC_ACCESS || $this->isGameMaster())
                $neutralLoreBlocks[] = $loreBlock;
            }
        }

        return $this->render('front/game-home/game-home.html.twig', [
            'publicGameLoreBlocks' => $neutralLoreBlocks,
            'isGameMaster' => $this->isGameMaster()
        ]);
    }

}
