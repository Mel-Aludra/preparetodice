<?php

namespace App\Controller\GameBack;

use App\Entity\Resource;
use App\Form\GameBack\ResourceType;
use App\Service\CharacteristicsManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ResourceController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/resource")
 */
class ResourceController extends Controller
{
    /**
     * @Route("/list", name="gameBack_resource_list")
     * @return Response
     */
    public function list()
    {
        return $this->render('back/resource/list.html.twig', [
            'resources' => $this->getGame()->getResources()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_resource_add")
     * @Route("/update/{resource}", name="gameBack_resource_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Resource|null $resource
     * @param CharacteristicsManager $characteristicsManager
     * @return Response
     */
    public function addAndUpdate(EntityManagerInterface $manager, Request $request, ?Resource $resource, CharacteristicsManager $characteristicsManager)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $resource = new Resource();
        else
            $this->checkEntityGameContext($resource);

        //Create form and handle request
        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $resource->setGame($this->getGame());
            $manager->persist($resource);
            $this->getGame()->addResource($resource);
            $characteristicsManager->rebuildCharacteristics();
            $manager->flush();
            $message = "Resource " . $resource->getName() . " have been created.";
            if($context == "update")
                $message = "Resource " . $resource->getName() . " have been updated.";
            $this->addFlash("success", $message);
            return $this->redirectToRoute('gameBack_resource_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/resource/edit.html.twig', [
            'form' => $form->createView(),
            'resource' => $resource,
            'context' => $context
        ]);
    }

    /**
     * @Route("/define-as-life", name="gameBack_resource_defineAsLife")
     * @return Response
     */
    public function defineAsLife()
    {
        return $this->render('back/resource/define-as-life.html.twig', ['resources' => $this->getGame()->getResources()]);
    }

    /**
     * @Route("/define-as-action", name="gameBack_resource_defineAsAction")
     * @return Response
     */
    public function defineAsAction()
    {
        return $this->render('back/resource/define-as-action.html.twig', ['resources' => $this->getGame()->getResources()]);
    }

    /**
     * @Route("/define-as-life/{resource}", name="gameBack_resource_defineAsLifeSelected")
     * @param Resource|null $resource
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function defineAsLifeSelected(Resource $resource, EntityManagerInterface $manager)
    {
        if($this->getGame()->getId() !== $resource->getGame()->getId()) {
            $this->addFlash('error', 'Do you really think you can use a resource from another game?');
        }
        else if($this->getGame()->getActionPointsResource() !== null && $this->getGame()->getActionPointsResource()->getId() === $resource->getId()) {
            $this->addFlash('error', 'This resource is already use for action points.');
        }
        else {
            $this->getGame()->setLifeResource($resource);
            $manager->persist($this->getGame());
            $manager->flush();
            $this->addFlash('success', 'The resource ' . $resource->getName() . ' have been selected as life resource.');
        }
        return $this->redirectToRoute('gameBack_resource_list', ["game" => $this->getGame()->getId()]);
    }

    /**
     * @Route("/define-as-action/{resource}", name="gameBack_resource_defineAsActionSelected")
     * @param Resource|null $resource
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function defineAsActionSelected(Resource $resource, EntityManagerInterface $manager)
    {
        if($this->getGame()->getId() !== $resource->getGame()->getId()) {
            $this->addFlash('error', 'Do you really think you can use a resource from another game?');
        }
        else if($this->getGame()->getLifeResource() !== null && $this->getGame()->getLifeResource()->getId() === $resource->getId()) {
            $this->addFlash('error', 'This resource is already use for life points.');
        }
        else {
            $this->getGame()->setActionPointsResource($resource);
            $manager->persist($this->getGame());
            $manager->flush();
            $this->addFlash('success', 'The resource ' . $resource->getName() . ' have been selected as action points resource.');
        }
        return $this->redirectToRoute('gameBack_resource_list', ["game" => $this->getGame()->getId()]);
    }

    /**
     * @Route("/delete/{resource}", name="gameBack_resource_delete")
     * @param Resource|null $resource
     * @param EntityManagerInterface $manager
     * @param CharacteristicsManager $characteristicsManager
     * @return Response
     */
    public function delete(Resource $resource, EntityManagerInterface $manager, CharacteristicsManager $characteristicsManager)
    {
        //Remove from game
        $manager->remove($resource);
        $this->getGame()->removeResource($resource);

        //Rebuild characteristics
        $characteristicsManager->rebuildCharacteristics();

        //Flush and flash
        $manager->flush();
        $this->addFlash("success", "Resource " . $resource->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_character_list', ['game' => $this->getGame()->getId()]);
    }
}
