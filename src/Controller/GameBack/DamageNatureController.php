<?php

namespace App\Controller\GameBack;

use App\Entity\Attribute;
use App\Entity\DamageNature;
use App\Form\GameBack\AttributeType;
use App\Form\GameBack\DamageNatureType;
use App\Repository\AttributeAlterationRepository;
use App\Repository\CharacterAttributeRepository;
use App\Service\CharacteristicsManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AttributeController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/nature")
 */
class DamageNatureController extends Controller
{
    /**
     * @Route("/list", name="gameBack_nature_list")
     * @return Response
     */
    public function list()
    {
        return $this->render('back/damage-nature/list.html.twig', [
            'damageNatures' => $this->getGame()->getDamageNatures()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_nature_add")
     * @Route("/update/{damageNature}", name="gameBack_nature_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param DamageNature|null $damageNature
     * @return Response
     */
    public function addAndUpdate(EntityManagerInterface $manager, Request $request, ?DamageNature $damageNature)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $damageNature = new DamageNature();
        else
            $this->checkEntityGameContext($damageNature);

        //Create form and handle request
        $form = $this->createForm(DamageNatureType::class, $damageNature);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $damageNature->setGame($this->getGame());
            $manager->persist($damageNature);
            $this->getGame()->addDamageNature($damageNature);
            $manager->flush();
            $message = "Damage nature " . $damageNature->getName() . " have been created.";
            if($context == "update")
                $message = "Damage nature " . $damageNature->getName() . " have been updated.";
            $this->addFlash("success", $message);
            return $this->redirectToRoute('gameBack_nature_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/damage-nature/edit.html.twig', [
            'form' => $form->createView(),
            'damageNature' => $damageNature,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{damageNature}", name="gameBack_nature_delete")
     * @param DamageNature|null $damageNature
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(DamageNature $damageNature, EntityManagerInterface $manager)
    {
        //Remove from game
        $manager->remove($damageNature);
        $manager->persist($damageNature);
        $this->getGame()->removeDamageNature($damageNature);

        //Flush and flash
        $manager->flush();
        $this->addFlash("success", "Damage nature " . $damageNature->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_nature_list', ['game' => $this->getGame()->getId()]);
    }
}
