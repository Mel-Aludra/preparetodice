<?php

namespace App\Controller\GameBack;

use App\Entity\Item;
use App\Form\GameBack\EntitiesFilterType;
use App\Form\GameBack\ItemType;
use App\Repository\ItemRepository;
use App\Service\EntitiesFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ItemController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/item")
 */
class ItemController extends Controller
{
    /**
     * @Route("/list/{page<\d+>?1}", name="gameBack_item_list")
     * @param ItemRepository $repo
     * @param int $page
     * @param Request $request
     * @return Response
     */
    public function list(ItemRepository $repo, int $page, Request $request)
    {
        //Manage paging with filters and ordering post
        $entitiesFiltersForm = $this->createForm(EntitiesFilterType::class, null, [
            "filtersElements" => ["name", "description"],
            "sortingElements" => ["id", "name"]
        ]);
        $entitiesFiltersService = new EntitiesFilterService($repo, $page, 'gameBack_item_list', $this->getGame(), $entitiesFiltersForm, $request);

        //Return view
        return $this->render('back/item/list.html.twig', [
            'items' => $entitiesFiltersService->getEntities(),
            'entitiesFiltersService' => $entitiesFiltersService->createView()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_item_add")
     * @Route("/update/{item}", name="gameBack_item_update")
     * @param EntityManagerInterface $manager
     * @param Request                $request
     * @param Item|null     $item
     *
     * @return Response
     */
    public function addAndUpdateItem(EntityManagerInterface $manager, Request $request, ?Item $item)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $item = new Item();
        else
            $this->checkEntityGameContext($item);

        //Create form and handle request
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $item->setGame($this->getGame());
            $manager->persist($item);
            $this->getGame()->addItem($item);
            $manager->flush();

            //Flush and flash
            $manager->flush();
            $message = "Item " . $item->getName() . " have been created.";
            if($context == "update")
                $message = "Item " . $item->getName() . " have been updated.";
            $this->addFlash("success", $message);

            return $this->redirectToRoute('gameBack_item_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/item/edit.html.twig', [
            'form' => $form->createView(),
            'item' => $item,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{item}", name="gameBack_item_delete")
     * @param EntityManagerInterface $manager
     * @param Item|null $item
     * @return Response
     */
    public function delete(Item $item, EntityManagerInterface $manager)
    {
        $manager->remove($item);
        $manager->flush();
        $this->addFlash("success", "Item " . $item->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_item_list', ['game' => $this->getGame()->getId()]);
    }
}
