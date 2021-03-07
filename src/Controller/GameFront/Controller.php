<?php

namespace App\Controller\GameFront;

use App\Entity\Game;
use App\Service\GameEnv;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Twig\Environment;

/**
 * Class Controller
 * @package App\Controller\GameBack
 */
class Controller extends AbstractController
{

    /** @var GameEnv $gameEnv */
    private GameEnv $gameEnv;

    /**
     * Controller constructor.
     * @param GameEnv $gameEnv
     * @param Environment $twigEnv
     */
    public function __construct(GameEnv $gameEnv, Environment $twigEnv)
    {
        //Check access to current game
        if(!$gameEnv->allowGameAccess()) {
            throw new AccessDeniedHttpException("You don't have permission to access this game.");
        }
        $this->gameEnv = $gameEnv;

        //Add current game to twig env so we can use game in every template
        $twigEnv->addGlobal('game', $gameEnv->getGame());
    }

    /**
     * @return Game|null
     */
    public function getGame()
    {
        return $this->gameEnv->getGame();
    }

    protected function isGameMaster()
    {
        return $this->getUser()->isGameMaster($this->getGame()->getId());
    }

}
