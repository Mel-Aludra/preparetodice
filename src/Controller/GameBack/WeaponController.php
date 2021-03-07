<?php

namespace App\Controller\GameBack;

use App\Entity\Weapon;
use App\Form\GameBack\EntitiesFilterType;
use App\Form\GameBack\WeaponType;
use App\Repository\WeaponRepository;
use App\Service\EntitiesFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ResourceController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/weapon")
 */
class WeaponController extends Controller
{
    /**
     * @Route("/list/{page<\d+>?1}", name="gameBack_weapon_list")
     * @param WeaponRepository $repo
     * @param int $page
     * @param Request $request
     * @return Response
     */
    public function list(WeaponRepository $repo, int $page, Request $request)
    {
        //Manage paging with filters and ordering post
        $entitiesFiltersForm = $this->createForm(EntitiesFilterType::class, null, [
            "filtersElements" => ["name", "description"],
            "sortingElements" => ["id", "name"]
        ]);
        $entitiesFiltersService = new EntitiesFilterService($repo, $page, 'gameBack_weapon_list', $this->getGame(), $entitiesFiltersForm, $request);

        //Return view
        return $this->render('back/weapon/list.html.twig', [
            'weapons' => $entitiesFiltersService->getEntities(),
            'entitiesFiltersService' => $entitiesFiltersService->createView()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_weapon_add")
     * @Route("/update/{weapon}", name="gameBack_weapon_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Weapon|null $weapon
     * @return Response
     */
    public function addAndUpdate(EntityManagerInterface $manager, Request $request, ?Weapon $weapon)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $weapon = new Weapon();
        else
            $this->checkEntityGameContext($weapon);

        //Create form and handle request
        $form = $this->createForm(WeaponType::class, $weapon);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $weapon->setGame($this->getGame());
            $manager->persist($weapon);
            $this->getGame()->addWeapon($weapon);

            //Add costs
            foreach($weapon->getSkillCosts() as $cost) {
                $cost->setWeapon($weapon);
                $manager->persist($cost);
            }

            //Add gains
            foreach($weapon->getSkillGains() as $gain) {
                $gain->setWeapon($weapon);
                $manager->persist($gain);
            }

            //Add damages
            foreach($weapon->getSkillDamageEffects() as $effect) {
                $effect->setWeapon($weapon);
                $manager->persist($effect);
            }

            //Add heal
            foreach($weapon->getSkillHealEffects() as $effect) {
                $effect->setWeapon($weapon);
                $manager->persist($effect);
            }

            //Add status effects
            foreach($weapon->getSkillStatusEffects() as $effect) {
                $effect->setWeapon($weapon);
                $manager->persist($effect);
            }

            //Flush and flash
            $manager->flush();
            $message = "Weapon " . $weapon->getName() . " have been created.";
            if($context == "update")
                $message = "Weapon " . $weapon->getName() . " have been updated.";
            $this->addFlash("success", $message);

            //Redirect on Weapons
            return $this->redirectToRoute('gameBack_weapon_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/weapon/edit.html.twig', [
            'form' => $form->createView(),
            'weapon' => $weapon,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{weapon}", name="gameBack_weapon_delete")
     * @param EntityManagerInterface $manager
     * @param Weapon|null $weapon
     * @return Response
     */
    public function delete(Weapon $weapon, EntityManagerInterface $manager)
    {
        $manager->remove($weapon);
        foreach($weapon->getSkillHealEffects() as $child) { $manager->remove($child); }
        foreach($weapon->getSkillDamageEffects() as $child) { $manager->remove($child); }
        foreach($weapon->getSkillStatusEffects() as $child) { $manager->remove($child); }
        foreach($weapon->getSkillCosts() as $child) { $manager->remove($child); }
        foreach($weapon->getSkillGains() as $child) { $manager->remove($child); }
        $manager->flush();
        $this->addFlash("success", "Weapon " . $weapon->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_weapon_list', ['game' => $this->getGame()->getId()]);
    }

}
