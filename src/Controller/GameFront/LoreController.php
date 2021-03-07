<?php

namespace App\Controller\GameFront;

use App\Entity\LoreBlock;
use App\Entity\LoreTag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller\GameFront
 * @Route("/game/{game}/lore")
 */
class LoreController extends Controller
{

    /**
     * @Route("/{loreTag}", name="gameFront_lore_tag")
     * @param LoreTag $loreTag
     * @return Response
     */
    public function tag(LoreTag $loreTag)
    {

        //We get game public elements that is not related to some tags
        $neutralLoreBlocks = [];
        foreach($loreTag->getRelatedBlocks() as $loreBlock) {
            if($loreBlock->getAccessType() === LoreBlock::PUBLIC_ACCESS && $loreBlock->getTag() === null) {
                $neutralLoreBlocks[] = $loreBlock;
            }
        }

        return $this->render('front/game-lore/game-lore.html.twig', [
            'publicGameLoreBlocks' => $neutralLoreBlocks,
            'loreTag' => $loreTag
        ]);
    }

}
