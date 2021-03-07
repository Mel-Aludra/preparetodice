<?php

namespace App\Controller\GameBack;

use App\Entity\PotencyAugmentator;
use App\Form\GameBack\EntitiesFilterType;
use App\Form\GameBack\PotencyAugmentatorType;
use App\Repository\PotencyAugmentatorRepository;
use App\Service\EntitiesFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PotencyAugmentatorController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/potency")
 */
class PotencyAugmentatorController extends Controller
{
    /**
     * @Route("/list/{page<\d+>?1}", name="gameBack_potency_list")
     * @param PotencyAugmentatorRepository $repo
     * @param int $page
     * @param Request $request
     * @return Response
     */
    public function list(PotencyAugmentatorRepository $repo, int $page, Request $request)
    {
        //Manage paging with filters and ordering post
        $entitiesFiltersForm = $this->createForm(EntitiesFilterType::class, null, [
            "filtersElements" => ["name", "description"],
            "sortingElements" => ["id", "name"]
        ]);
        $entitiesFiltersService = new EntitiesFilterService($repo, $page, 'gameBack_potency_list', $this->getGame(), $entitiesFiltersForm, $request);

        //Return view
        return $this->render('back/potency/list.html.twig', [
            'potencyAugmentators' => $entitiesFiltersService->getEntities(),
            'entitiesFiltersService' => $entitiesFiltersService->createView()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_potency_add")
     * @Route("/update/{potencyAugmentator}", name="gameBack_potency_update")
     * @param EntityManagerInterface $manager
     * @param Request                $request
     * @param PotencyAugmentator|null     $potencyAugmentator
     *
     * @return Response
     */
    public function addAndUpdatePotencyAugmentator(EntityManagerInterface $manager, Request $request, ?PotencyAugmentator $potencyAugmentator)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $potencyAugmentator = new PotencyAugmentator();
        else
            $this->checkEntityGameContext($potencyAugmentator);

        //Create form and handle request
        $form = $this->createForm(PotencyAugmentatorType::class, $potencyAugmentator);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $potencyAugmentator->setGame($this->getGame());
            $manager->persist($potencyAugmentator);
            $this->getGame()->addPotencyAugmentator($potencyAugmentator);
            $manager->flush();

            //Flush and flash
            $manager->flush();
            $message = "Potency augmentator " . $potencyAugmentator->getName() . " have been created.";
            if($context == "update")
                $message = "Potency augmentator " . $potencyAugmentator->getName() . " have been updated.";
            $this->addFlash("success", $message);

            return $this->redirectToRoute('gameBack_potency_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/potency/edit.html.twig', [
            'form' => $form->createView(),
            'potencyAugmentator' => $potencyAugmentator,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{potencyAugmentator}", name="gameBack_potency_delete")
     * @param EntityManagerInterface $manager
     * @param PotencyAugmentator|null $potencyAugmentator
     * @return Response
     */
    public function delete(PotencyAugmentator $potencyAugmentator, EntityManagerInterface $manager)
    {
        $manager->remove($potencyAugmentator);
        $manager->flush();
        $this->addFlash("success", "PotencyAugmentator " . $potencyAugmentator->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_potency_list', ['game' => $this->getGame()->getId()]);
    }
}
