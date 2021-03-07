<?php

namespace App\Controller\GameBack;

use App\Entity\EquipmentSlot;
use App\Form\GameBack\EquipmentSlotType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AttributeController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/slot")
 */
class EquipmentSlotController extends Controller
{
    /**
     * @Route("/list", name="gameBack_slot_list")
     * @return Response
     */
    public function list()
    {
        return $this->render('back/equipment-slot/list.html.twig', [
            'equipmentSlots' => $this->getGame()->getEquipmentSlots()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_slot_add")
     * @Route("/update/{equipmentSlot}", name="gameBack_slot_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param EquipmentSlot|null $equipmentSlot
     * @return Response
     */
    public function addAndUpdate(EntityManagerInterface $manager, Request $request, ?EquipmentSlot $equipmentSlot)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $equipmentSlot = new EquipmentSlot();
        else
            $this->checkEntityGameContext($equipmentSlot);

        //Create form and handle request
        $form = $this->createForm(EquipmentSlotType::class, $equipmentSlot);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $equipmentSlot->setGame($this->getGame());
            $manager->persist($equipmentSlot);
            $this->getGame()->addEquipmentSlot($equipmentSlot);
            $manager->flush();
            $message = "Equipment slot " . $equipmentSlot->getName() . " have been created.";
            if($context == "update")
                $message = "Equipment slot " . $equipmentSlot->getName() . " have been updated.";
            $this->addFlash("success", $message);
            return $this->redirectToRoute('gameBack_slot_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/equipment-slot/edit.html.twig', [
            'form' => $form->createView(),
            'equipmentSlot' => $equipmentSlot,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{equipmentSlot}", name="gameBack_slot_delete")
     * @param EquipmentSlot|null $equipmentSlot
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(EquipmentSlot $equipmentSlot, EntityManagerInterface $manager)
    {
        //Remove from game
        $manager->remove($equipmentSlot);
        $manager->persist($equipmentSlot);
        $this->getGame()->removeEquipmentSlot($equipmentSlot);

        //Flush and flash
        $manager->flush();
        $this->addFlash("success", "Equipment slot " . $equipmentSlot->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_slot_list', ['game' => $this->getGame()->getId()]);
    }
}
