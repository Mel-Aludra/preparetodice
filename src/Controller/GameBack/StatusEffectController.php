<?php

namespace App\Controller\GameBack;

use App\Entity\StatusEffect;
use App\Form\GameBack\EntitiesFilterType;
use App\Form\GameBack\StatusEffectType;
use App\Repository\StatusEffectRepository;
use App\Service\CharacteristicsManager;
use App\Service\EntitiesFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StatusEffectController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/status-effect")
 */
class StatusEffectController extends Controller
{
    /**
     * @Route("/list/{page<\d+>?1}", name="gameBack_statusEffect_list")
     * @param StatusEffectRepository $repo
     * @param int $page
     * @param Request $request
     * @return Response
     */
    public function list(StatusEffectRepository $repo, int $page, Request $request)
    {
        //Manage paging with filters and ordering post
        $entitiesFiltersForm = $this->createForm(EntitiesFilterType::class, null, [
            "filtersElements" => ["name", "description"],
            "sortingElements" => ["id", "name"]
        ]);
        $entitiesFiltersService = new EntitiesFilterService($repo, $page, 'gameBack_statusEffect_list', $this->getGame(), $entitiesFiltersForm, $request);

        //Return view
        return $this->render('back/status-effect/list.html.twig', [
            'statusEffects' => $entitiesFiltersService->getEntities(),
            'entitiesFiltersService' => $entitiesFiltersService->createView()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_statusEffect_add")
     * @Route("/update/{statusEffect}", name="gameBack_statusEffect_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param StatusEffect|null $statusEffect
     * @param CharacteristicsManager $characteristicsManager
     * @return Response
     */
    public function addAndUpdate(EntityManagerInterface $manager, Request $request, ?StatusEffect $statusEffect, CharacteristicsManager $characteristicsManager)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $statusEffect = new StatusEffect();
        else
            $this->checkEntityGameContext($statusEffect);

        //Create form and handle request
        $form = $this->createForm(StatusEffectType::class, $statusEffect);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $statusEffect->setGame($this->getGame());
            $manager->persist($statusEffect);
            $this->getGame()->addStatusEffect($statusEffect);

            //Add alterations
            foreach($statusEffect->getAttributeAlterations() as $alteration) {
                $alteration->setStatusEffect($statusEffect);
                $manager->persist($alteration);
                $statusEffect->addAttributeAlteration($alteration);
            }
            foreach($statusEffect->getResourceAlterations() as $alteration) {
                $alteration->setStatusEffect($statusEffect);
                $manager->persist($alteration);
                $statusEffect->addResourceAlteration($alteration);
            }

            //Add dot
            foreach($statusEffect->getDamageOverTimes() as $dot) {
                $dot->setStatusEffect($statusEffect);
                $manager->persist($dot);
                $statusEffect->addDamageOverTime($dot);
            }

            //Add heal
            foreach($statusEffect->getHealOverTimes() as $hot) {
                $hot->setStatusEffect($statusEffect);
                $manager->persist($hot);
                $statusEffect->addHealOverTime($hot);
            }

            //Flush and flash
            $manager->flush();
            $message = "Status effect " . $statusEffect->getName() . " have been created.";
            if($context == "update") {
                $message = "Status effect " . $statusEffect->getName() . " have been updated.";
                $characteristicsManager->recalculateAllCharacteristics();
            }
            $this->addFlash("success", $message);

            //Redirect on skills
            return $this->redirectToRoute('gameBack_statusEffect_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/status-effect/edit.html.twig', [
            'form' => $form->createView(),
            'statusEffect' => $statusEffect,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{statusEffect}", name="gameBack_statusEffect_delete")
     * @param EntityManagerInterface $manager
     * @param StatusEffect|null $statusEffect
     * @return Response
     */
    public function delete(StatusEffect $statusEffect, EntityManagerInterface $manager)
    {
        $manager->remove($statusEffect);
        foreach($statusEffect->getHealOverTimes() as $child) {
            $manager->remove($child);
        }
        foreach($statusEffect->getDamageOverTimes() as $child) {
            $manager->remove($child);
        }
        foreach($statusEffect->getResourceAlterations() as $child) {
            $manager->remove($child);
        }
        foreach($statusEffect->getAttributeAlterations() as $child) {
            $manager->remove($child);
        }
        $manager->flush();
        $this->addFlash("success", "Status effect " . $statusEffect->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_statusEffect_list', ['game' => $this->getGame()->getId()]);
    }

}
