<?php

namespace App\Controller\GameBack;

use App\Entity\Consumable;
use App\Form\GameBack\ConsumableType;
use App\Form\GameBack\EntitiesFilterType;
use App\Repository\ConsumableRepository;
use App\Service\EntitiesFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ResourceController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/consumable")
 */
class ConsumableController extends Controller
{
    /**
     * @Route("/list/{page<\d+>?1}", name="gameBack_consumable_list")
     * @param ConsumableRepository $repo
     * @param int $page
     * @param Request $request
     * @return Response
     */
    public function list(ConsumableRepository $repo, int $page, Request $request)
    {
        //Manage paging with filters and ordering post
        $entitiesFiltersForm = $this->createForm(EntitiesFilterType::class, null, [
            "filtersElements" => ["name", "description"],
            "sortingElements" => ["id", "name"]
        ]);
        $entitiesFiltersService = new EntitiesFilterService($repo, $page, 'gameBack_consumable_list', $this->getGame(), $entitiesFiltersForm, $request);

        //Return view
        return $this->render('back/consumable/list.html.twig', [
            'consumables' => $entitiesFiltersService->getEntities(),
            'entitiesFiltersService' => $entitiesFiltersService->createView()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_consumable_add")
     * @Route("/update/{consumable}", name="gameBack_consumable_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Consumable|null $consumable
     * @return Response
     */
    public function addAndUpdate(EntityManagerInterface $manager, Request $request, ?Consumable $consumable)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $consumable = new Consumable();
        else
            $this->checkEntityGameContext($consumable);

        //Create form and handle request
        $form = $this->createForm(ConsumableType::class, $consumable);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $consumable->setGame($this->getGame());
            $manager->persist($consumable);
            $this->getGame()->addConsumable($consumable);

            //Add damages
            foreach($consumable->getSkillDamageEffects() as $effect) {
                $effect->setConsumable($consumable);
                $manager->persist($effect);
                $consumable->addSkillDamageEffect($effect);
            }

            //Add heal
            foreach($consumable->getSkillHealEffects() as $effect) {
                $effect->setConsumable($consumable);
                $manager->persist($effect);
                $consumable->addSkillHealEffect($effect);
            }

            //Add status effects
            foreach($consumable->getSkillStatusEffects() as $effect) {
                $effect->setConsumable($consumable);
                $manager->persist($effect);
                $consumable->addSkillStatusEffect($effect);
            }

            //Flush and flash
            $manager->flush();
            $message = "Consumable " . $consumable->getName() . " have been created.";
            if($context == "update")
                $message = "Consumable " . $consumable->getName() . " have been updated.";
            $this->addFlash("success", $message);

            //Redirect on skills
            return $this->redirectToRoute('gameBack_consumable_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/consumable/edit.html.twig', [
            'form' => $form->createView(),
            'consumable' => $consumable,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{consumable}", name="gameBack_consumable_delete")
     * @param EntityManagerInterface $manager
     * @param Consumable|null $consumable
     * @return Response
     */
    public function delete(Consumable $consumable, EntityManagerInterface $manager)
    {
        $manager->remove($consumable);
        foreach($consumable->getSkillHealEffects() as $child) { $manager->remove($child); }
        foreach($consumable->getSkillDamageEffects() as $child) { $manager->remove($child); }
        foreach($consumable->getSkillStatusEffects() as $child) { $manager->remove($child); }
        $manager->flush();
        $this->addFlash("success", "Skill " . $consumable->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_consumable_list', ['game' => $this->getGame()->getId()]);
    }

}
