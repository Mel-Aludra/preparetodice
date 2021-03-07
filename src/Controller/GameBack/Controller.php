<?php

namespace App\Controller\GameBack;

use App\Entity\Game;
use App\Form\GameBack\EntitiesFilterType;
use App\Service\GameEnv;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Twig\Environment;

/**
 * Class Controller
 * @package App\Controller\GameBack
 */
class Controller extends AbstractController
{

    /** @var GameEnv $gameEnv */
    protected GameEnv $gameEnv;

    /**
     * Controller constructor.
     * @param GameEnv $gameEnv
     * @param Environment $twigEnv
     */
    public function __construct(GameEnv $gameEnv, Environment $twigEnv)
    {
        //Check access to current game
        if(!$gameEnv->allowGameBackAccess()) {
            throw new AccessDeniedHttpException("You don't have permission to access this game as a GM.");
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

    /**
     * @param $entity
     */
    public function checkEntityGameContext($entity)
    {
        if(!$this->gameEnv->isFromThisGame($entity))
            throw new AccessDeniedHttpException("You can't access elements from other game.");
    }

    public function getFormContext()
    {
        $route = $this->container->get('request_stack')->getCurrentRequest()->get("_route");
        $routeElements = explode("_", $route);
        $routeLastElement = $routeElements[count($routeElements) - 1];
        if($routeLastElement === "update")
            return "update";
        elseif($routeLastElement === "add")
            return "add";
        return null;
    }

}
