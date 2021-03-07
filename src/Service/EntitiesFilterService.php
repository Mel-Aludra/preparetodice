<?php

namespace App\Service;

use App\Entity\Game;
use App\Form\GameBack\EntitiesFilterType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class EntitiesFilterService
{

    /* Tools */
    private ServiceEntityRepositoryInterface $repo;
    private Game $game;
    private Form $form;
    private Request $request;

    /* Page infos */
    private int $currentPageNumber;
    private string $routeName;

    /* Filters, orders and interval infos */
    private int $interval = 40;
    private array $filteringClauses = [];
    private array $orderingClauses = [];

    /* For displaying */
    private int $totalPages = 0;

    public function __construct($repo, $currentPageNumber, $routeName, $game, $form, $request)
    {
        $this->repo = $repo;
        $this->currentPageNumber = $currentPageNumber;
        $this->routeName = $routeName;
        $this->game = $game;
        $this->form = $form;
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getEntities() :array
    {
        try {

            $this->handleSearchingForm();

            //We build query for counter
            $query = $this->repo->createQueryBuilder('e')->where('e.game = :gameId');
            $query->setParameter('gameId', $this->game->getId());
            foreach($this->filteringClauses as $key => $value) {
                $query->andWhere('e.' . $key . ' LIKE :' . $key);
                $query->setParameter($key, '%' . $value . '%');
            }
            $counter = count($query->getQuery()->getResult());

            //We get total of pages and range we have to send
            $this->totalPages = (int) ceil($counter / $this->interval);
            $offset = $this->currentPageNumber * $this->interval - $this->interval;

            //We launch query for final result
            $query = $this->repo->createQueryBuilder('e')->where('e.game = :gameId');
            $query->setParameter('gameId', $this->game->getId());
            foreach($this->filteringClauses as $key => $value) {
                $query->andWhere('e.' . $key . ' LIKE :' . $key);
                $query->setParameter($key, '%' . $value . '%');
            }
            $query->orderBy('e.' . $this->orderingClauses["field"], $this->orderingClauses["type"]);
            $query->setFirstResult($offset);
            $query->setMaxResults($this->interval);
            return $query->getQuery()->getResult();

        } catch(\Exception $e) {

            $counter = count($this->repo->findBy(["game"=> $this->game->getId()]));
            $this->totalPages = (int) ceil($counter / $this->interval);
            $offset = $this->currentPageNumber * $this->interval - $this->interval;
            return $this->repo->findBy(["game"=> $this->game->getId()], null, $this->interval, $offset);

        }

    }


    public function handleSearchingForm()
    {
        //Retrieve from session or trash all filters
        if(isset($_POST["cancelPagingValues"])) {
            unset($_SESSION["paging"][get_class($this->repo)]);
        }
        else if(isset($_SESSION["paging"][get_class($this->repo)])) {
            $this->orderingClauses = $_SESSION["paging"][get_class($this->repo)]["order"];
            $this->filteringClauses = $_SESSION["paging"][get_class($this->repo)]["filters"];
        }

        $this->form->handleRequest($this->request);
        if($this->form->isSubmitted() && $this->form->isValid()) {

            unset($_SESSION["paging"][get_class($this->repo)]);
            $this->orderingClauses = [];
            $this->filteringClauses = [];

            //Search by name
            foreach(EntitiesFilterType::FILTERS_ALLOWED_ELEMENTS as $key => $value) {
                if(isset($this->form->getData()[$key]) && $this->form->getData()[$key] !== "") {
                    $this->filteringClauses[$key] = $this->form->getData()[$key];
                }
            }

            //Ordering
            if(isset($this->form->getData()["sort"])) {
                $elements = explode("_", $this->form->getData()["sort"]);
                if(count($elements) == 2 && ($elements[1] == "ASC" || $elements[1] == "DESC")) {
                    $this->orderingClauses["field"] = $elements[0];
                    $this->orderingClauses["type"] = $elements[1];
                }
            }

            //Save in session
            $_SESSION["paging"][get_class($this->repo)]["filters"] = $this->filteringClauses;
            $_SESSION["paging"][get_class($this->repo)]["order"] = $this->orderingClauses;

        }

    }

    public function createView()
    {
        //We get previous page
        $previousPage = $this->currentPageNumber - 1;
        if($previousPage < 1)
            $previousPage = null;

        //We get next page
        $nextPage = $this->currentPageNumber + 1;
        if($nextPage > $this->totalPages)
            $nextPage = null;

        //Filters mention
        $mention = null;
        if(count($this->orderingClauses) > 0 || count($this->filteringClauses) > 0) {
            $mention = "";
            if(count($this->filteringClauses) > 0) {
                $filters = "Filters: ";
                foreach($this->filteringClauses as $key => $value) {
                    $filters = $filters . " " . $key . " > '" . $value . "' ";
                }
                $mention = $filters;
            }
            if(count($this->orderingClauses) > 0) {
                $mention = $mention . " / Order: " . $this->orderingClauses["field"];
                if($this->orderingClauses["type"] !== "ASC") {
                    $mention = $mention . " (ZA)";
                } else {
                    $mention = $mention . " (AZ)";
                }
            }
        }

        //We return data for template
        return [
            "totalPages" => $this->totalPages,
            "currentPage" => $this->currentPageNumber,
            "previousPage" => $previousPage,
            "nextPage" => $nextPage,
            "route" => $this->routeName,
            "interval" => $this->interval,
            "searchForm" => $this->form->createView(),
            "filters" => $mention
        ];
    }

}