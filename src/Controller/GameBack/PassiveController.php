<?php

namespace App\Controller\GameBack;

use App\Entity\Passive;
use App\Form\GameBack\EntitiesFilterType;
use App\Form\GameBack\PassiveType;
use App\Repository\PassiveRepository;
use App\Service\CharacteristicsManager;
use App\Service\EntitiesFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PassiveController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/passive")
 */
class PassiveController extends Controller
{
    /**
     * @Route("/list/{page<\d+>?1}", name="gameBack_passive_list")
     * @param PassiveRepository $repo
     * @param int $page
     * @param Request $request
     * @return Response
     */
    public function list(PassiveRepository $repo, int $page, Request $request)
    {
        //Manage paging with filters and ordering post
        $entitiesFiltersForm = $this->createForm(EntitiesFilterType::class, null, [
            "filtersElements" => ["name", "description"],
            "sortingElements" => ["id", "name"]
        ]);
        $entitiesFiltersService = new EntitiesFilterService($repo, $page, 'gameBack_passive_list', $this->getGame(), $entitiesFiltersForm, $request);

        //Return view
        return $this->render('back/passive/list.html.twig', [
            'passives' => $entitiesFiltersService->getEntities(),
            'entitiesFiltersService' => $entitiesFiltersService->createView()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_passive_add")
     * @Route("/update/{passive}", name="gameBack_passive_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Passive|null $passive
     * @param CharacteristicsManager $characteristicsManager
     * @return Response
     */
    public function addAndUpdate(EntityManagerInterface $manager, Request $request, ?Passive $passive, CharacteristicsManager $characteristicsManager)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $passive = new Passive();
        else
            $this->checkEntityGameContext($passive);

        //Create form and handle request
        $form = $this->createForm(PassiveType::class, $passive);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $passive->setGame($this->getGame());
            $manager->persist($passive);
            $this->getGame()->addPassive($passive);

            //Add alterations
            foreach($passive->getAttributeAlterations() as $alteration) {
                $alteration->setPassive($passive);
                $manager->persist($alteration);
                $passive->addAttributeAlteration($alteration);
            }
            foreach($passive->getResourceAlterations() as $alteration) {
                $alteration->setPassive($passive);
                $manager->persist($alteration);
                $passive->addResourceAlteration($alteration);
            }

            //Add dot
            foreach($passive->getDamageOverTimes() as $dot) {
                $dot->setPassive($passive);
                $manager->persist($dot);
                $passive->addDamageOverTime($dot);
            }

            //Add heal
            foreach($passive->getHealOverTimes() as $hot) {
                $hot->setPassive($passive);
                $manager->persist($hot);
                $passive->addHealOverTime($hot);
            }

            //Flush and flash
            $manager->flush();
            $message = "Passive " . $passive->getName() . " have been created.";
            if($context == "update") {
                $message = "Passive " . $passive->getName() . " have been updated.";
                $characteristicsManager->recalculateAllCharacteristics();
            }
            $this->addFlash("success", $message);

            //Redirect on skills
            return $this->redirectToRoute('gameBack_passive_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/passive/edit.html.twig', [
            'form' => $form->createView(),
            'passive' => $passive,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{passive}", name="gameBack_passive_delete")
     * @param EntityManagerInterface $manager
     * @param Passive|null $passive
     * @return Response
     */
    public function delete(Passive $passive, EntityManagerInterface $manager)
    {
        $manager->remove($passive);
        foreach($passive->getHealOverTimes() as $child) {
            $manager->remove($child);
        }
        foreach($passive->getDamageOverTimes() as $child) {
            $manager->remove($child);
        }
        foreach($passive->getResourceAlterations() as $child) {
            $manager->remove($child);
        }
        foreach($passive->getAttributeAlterations() as $child) {
            $manager->remove($child);
        }
        $manager->flush();
        $this->addFlash("success", "Passive " . $passive->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_passive_list', ['game' => $this->getGame()->getId()]);
    }

}
