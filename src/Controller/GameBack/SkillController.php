<?php

namespace App\Controller\GameBack;

use App\Entity\Skill;
use App\Form\GameBack\EntitiesFilterType;
use App\Form\GameBack\SkillType;
use App\Repository\SkillRepository;
use App\Service\EntitiesFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ResourceController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/skill")
 */
class SkillController extends Controller
{
    /**
     * @Route("/list/{page<\d+>?1}", name="gameBack_skill_list")
     * @param SkillRepository $repo
     * @param int $page
     * @param Request $request
     * @return Response
     */
    public function list(SkillRepository $repo, int $page, Request $request)
    {
        //Manage paging with filters and ordering post
        $entitiesFiltersForm = $this->createForm(EntitiesFilterType::class, null, [
            "filtersElements" => ["name", "description"],
            "sortingElements" => ["id", "name"]
        ]);
        $entitiesFiltersService = new EntitiesFilterService($repo, $page, 'gameBack_skill_list', $this->getGame(), $entitiesFiltersForm, $request);

        //Return view
        return $this->render('back/skill/list.html.twig', [
            'skills' => $entitiesFiltersService->getEntities(),
            'entitiesFiltersService' => $entitiesFiltersService->createView()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_skill_add")
     * @Route("/update/{skill}", name="gameBack_skill_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Skill|null $skill
     * @return Response
     */
    public function addAndUpdate(EntityManagerInterface $manager, Request $request, ?Skill $skill)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $skill = new Skill();
        else
            $this->checkEntityGameContext($skill);

        //Create form and handle request
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $skill->setGame($this->getGame());
            $manager->persist($skill);
            $this->getGame()->addSkill($skill);

            //Add costs
            foreach($skill->getSkillCosts() as $cost) {
                $cost->setSkill($skill);
                $manager->persist($cost);
            }

            //Add gains
            foreach($skill->getSkillGains() as $gain) {
                $gain->setSkill($skill);
                $manager->persist($gain);
            }

            //Add damages
            foreach($skill->getSkillDamageEffects() as $effect) {
                $effect->setSkill($skill);
                $manager->persist($effect);
                foreach($effect->getPotencyAugmentator() as $augmentator) {
                    $augmentator->addSkillDamageEffect($effect);
                    $manager->persist($augmentator);
                }
            }

            //Add heal
            foreach($skill->getSkillHealEffects() as $effect) {
                $effect->setSkill($skill);
                $manager->persist($effect);
                foreach($effect->getPotencyAugmentator() as $augmentator) {
                    $augmentator->addSkillHealEffect($effect);
                    $manager->persist($augmentator);
                }
            }

            //Add status effects
            foreach($skill->getSkillStatusEffects() as $effect) {
                $effect->setSkill($skill);
                $manager->persist($effect);
            }

            //Flush and flash
            $manager->flush();
            $message = "Skill " . $skill->getName() . " have been created.";
            if($context == "update")
                $message = "Skill " . $skill->getName() . " have been updated.";
            $this->addFlash("success", $message);

            //Redirect on skills
            return $this->redirectToRoute('gameBack_skill_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/skill/edit.html.twig', [
            'form' => $form->createView(),
            'skill' => $skill,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{skill}", name="gameBack_skill_delete")
     * @param EntityManagerInterface $manager
     * @param Skill|null $skill
     * @return Response
     */
    public function delete(Skill $skill, EntityManagerInterface $manager)
    {
        $manager->remove($skill);
        foreach($skill->getSkillHealEffects() as $child) { $manager->remove($child); }
        foreach($skill->getSkillDamageEffects() as $child) { $manager->remove($child); }
        foreach($skill->getSkillStatusEffects() as $child) { $manager->remove($child); }
        foreach($skill->getSkillCosts() as $child) { $manager->remove($child); }
        foreach($skill->getSkillGains() as $child) { $manager->remove($child); }
        $manager->flush();
        $this->addFlash("success", "Skill " . $skill->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_skill_list', ['game' => $this->getGame()->getId()]);
    }

}
