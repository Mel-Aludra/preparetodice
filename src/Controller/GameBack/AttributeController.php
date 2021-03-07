<?php

namespace App\Controller\GameBack;

use App\Entity\Attribute;
use App\Form\GameBack\AttributeType;
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
 * @Route("/back/{game}/attribute")
 */
class AttributeController extends Controller
{
    /**
     * @Route("/list", name="gameBack_attribute_list")
     * @return Response
     */
    public function list()
    {
        return $this->render('back/attribute/list.html.twig', [
            'attributes' => $this->getGame()->getAttributes()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_attribute_add")
     * @Route("/update/{attribute}", name="gameBack_attribute_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Attribute|null $attribute
     * @param CharacteristicsManager $characteristicsManager
     * @return Response
     */
    public function addAndUpdate(EntityManagerInterface $manager, Request $request, ?Attribute $attribute, CharacteristicsManager $characteristicsManager)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $attribute = new Attribute();
        else
            $this->checkEntityGameContext($attribute);

        //Create form and handle request
        $form = $this->createForm(AttributeType::class, $attribute);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $attribute->setGame($this->getGame());
            $manager->persist($attribute);
            foreach($attribute->getDefenses() as $defense) {
                $defense->setAttribute($attribute);
                $manager->persist($defense);
            }
            foreach($attribute->getAttributeEffects() as $attributeEffect) {
                $attributeEffect->setAttribute($attribute);
                $manager->persist($attributeEffect);
            }
            $this->getGame()->addAttribute($attribute);
            $characteristicsManager->rebuildCharacteristics();
            $characteristicsManager->recalculateAllCharacteristics();
            $manager->flush();
            $message = "Attribute " . $attribute->getName() . " have been created.";
            if($context == "update")
                $message = "Attribute " . $attribute->getName() . " have been updated.";
            $this->addFlash("success", $message);
            return $this->redirectToRoute('gameBack_attribute_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/attribute/edit.html.twig', [
            'form' => $form->createView(),
            'attribute' => $attribute,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{attribute}", name="gameBack_attribute_delete")
     * @param Attribute|null $attribute
     * @param EntityManagerInterface $manager
     * @param CharacteristicsManager $characteristicsManager
     * @param CharacterAttributeRepository $characterAttributeRepository
     * @return Response
     */
    public function delete(Attribute $attribute, EntityManagerInterface $manager, CharacteristicsManager $characteristicsManager, CharacterAttributeRepository $characterAttributeRepository, AttributeAlterationRepository $attributeAlterationRepository)
    {
        //Remove from game
        $manager->remove($attribute);
        $manager->persist($attribute);
        $this->getGame()->removeAttribute($attribute);

        //Rebuild characteristics for characters
        $characteristicsManager->rebuildCharacteristics();

        //Flush and flash
        $manager->flush();
        $this->addFlash("success", "Attribute " . $attribute->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_attribute_list', ['game' => $this->getGame()->getId()]);
    }
}
