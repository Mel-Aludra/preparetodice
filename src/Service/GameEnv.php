<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\UserGame;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class GameEnv
{

    private UserInterface $user;
    private GameRepository $gameRepo;
    private Game $game;

    /**
     * GameEnv constructor.
     * @param RequestStack $requestStack
     * @param GameRepository $gameRepository
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(RequestStack $requestStack, GameRepository $gameRepository, TokenStorageInterface $tokenStorage)
    {
        $this->gameRepo = $gameRepository;
        $this->game = $this->gameRepo->find($requestStack->getCurrentRequest()->attributes->get("game"));
        if($this->game === null) {
            throw new AccessDeniedHttpException("You don't have permission to access this game.");
        }
        $this->user = $tokenStorage->getToken()->getUser();
    }

    /**
     * Check permission for GM current game
     * @return bool
     */
    public function allowGameBackAccess() :bool
    {
        foreach($this->user->getUserGames() as $userGame) {
            if($userGame->getGame()->getId() === $this->getGame()->getId() && ($userGame->getAccessType() === UserGame::GM_ACCESS || $userGame->getAccessType() === UserGame::OWNER_ACCESS))
                return true;
        }
        return false;
    }

    /**
     * Check permission for current game
     * @return bool
     */
    public function allowGameAccess() :bool
    {
        foreach($this->user->getUserGames() as $userGame) {
            if($userGame->getGame()->getId() === $this->getGame()->getId()) {
                if($this->user->isGameMaster($this->getGame()->getId()) || $this->getGame()->getIsActive()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @return Game
     */
    public function getGame() {
        return $this->game;
    }


    /**
     * @param $entity
     * @return bool
     */
    public function isFromThisGame($entity)
    {
        if(method_exists($entity, "getGame")) {
            if($entity->getGame()->getId() === $this->getGame()->getId())
                return true;
        }
        return false;
    }

}