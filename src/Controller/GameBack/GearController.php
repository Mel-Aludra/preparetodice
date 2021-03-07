<?php

namespace App\Controller\GameBack;

use App\Entity\Gear;
use App\Form\GameBack\EntitiesFilterType;
use App\Form\GameBack\GearType;
use App\Repository\GearRepository;
use App\Service\CharacteristicsManager;
use App\Service\EntitiesFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GearController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/gear")
 */
class GearController extends Controller
{
    /**
     * @Route("/list/{page<\d+>?1}", name="gameBack_gear_list")
     * @param GearRepository $repo
     * @param int $page
     * @param Request $request
     * @return Response
     */
    public function list(GearRepository $repo, int $page, Request $request)
    {
        //Manage paging with filters and ordering post
        $entitiesFiltersForm = $this->createForm(EntitiesFilterType::class, null, [
            "filtersElements" => ["name", "description"],
            "sortingElements" => ["id", "name"]
        ]);
        $entitiesFiltersService = new EntitiesFilterService($repo, $page, 'gameBack_gear_list', $this->getGame(), $entitiesFiltersForm, $request);

        //Return view
        return $this->render('back/gear/list.html.twig', [
            'gears' => $entitiesFiltersService->getEntities(),
            'entitiesFiltersService' => $entitiesFiltersService->createView()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_gear_add")
     * @Route("/update/{gear}", name="gameBack_gear_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Gear|null $gear
     * @param CharacteristicsManager $characteristicsManager
     * @return Response
     */
    public function addAndUpdate(EntityManagerInterface $manager, Request $request, ?Gear $gear, CharacteristicsManager $characteristicsManager)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $gear = new Gear();
        else
            $this->checkEntityGameContext($gear);

        //Create form and handle request
        $form = $this->createForm(GearType::class, $gear);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $gear->setGame($this->getGame());
            $manager->persist($gear);
            $this->getGame()->addGear($gear);

            //Add alterations
            foreach($gear->getAttributeAlterations() as $alteration) {
                $alteration->setGear($gear);
                $manager->persist($alteration);
                $gear->addAttributeAlteration($alteration);
            }
            foreach($gear->getResourceAlterations() as $alteration) {
                $alteration->setGear($gear);
                $manager->persist($alteration);
                $gear->addResourceAlteration($alteration);
            }

            //Add dot
            foreach($gear->getDamageOverTimes() as $dot) {
                $dot->setGear($gear);
                $manager->persist($dot);
                $gear->addDamageOverTime($dot);
            }

            //Add heal
            foreach($gear->getHealOverTimes() as $hot) {
                $hot->setGear($gear);
                $manager->persist($hot);
                $gear->addHealOverTime($hot);
            }

            //Flush and flash
            $manager->flush();
            $message = "Gear " . $gear->getName() . " have been created.";
            if($context == "update") {
                $message = "Gear " . $gear->getName() . " have been updated.";
                $characteristicsManager->recalculateAllCharacteristics();
            }
            $this->addFlash("success", $message);

            //Redirect on skills
            return $this->redirectToRoute('gameBack_gear_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/gear/edit.html.twig', [
            'form' => $form->createView(),
            'gear' => $gear,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{gear}", name="gameBack_gear_delete")
     * @param EntityManagerInterface $manager
     * @param Gear|null $gear
     * @return Response
     */
    public function delete(Gear $gear, EntityManagerInterface $manager)
    {
        $manager->remove($gear);
        foreach($gear->getHealOverTimes() as $child) {
            $manager->remove($child);
        }
        foreach($gear->getDamageOverTimes() as $child) {
            $manager->remove($child);
        }
        foreach($gear->getResourceAlterations() as $child) {
            $manager->remove($child);
        }
        foreach($gear->getAttributeAlterations() as $child) {
            $manager->remove($child);
        }
        $manager->flush();
        $this->addFlash("success", "Gear " . $gear->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_gear_list', ['game' => $this->getGame()->getId()]);
    }

}
