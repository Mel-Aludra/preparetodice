<?php

namespace App\Controller\GameBack;

use App\Entity\GameCharacter;
use App\Entity\LoreBlock;
use App\Entity\LoreTag;
use App\Form\GameBack\EntitiesFilterType;
use App\Form\GameBack\GameCharacterType;
use App\Form\GameBack\LoreBlockType;
use App\Form\GameBack\LoreTagType;
use App\Repository\LoreBlockRepository;
use App\Service\EntitiesFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameCharacterController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/lore")
 */
class LoreController extends Controller
{

    /**
     * @Route("/list", name="gameBack_lore_list")
     * @return Response
     */
    public function list()
    {
        $globalLoreBlocks = [];
        $specificLoreBlocks = [];
        foreach($this->getGame()->getLoreBlocks() as $loreBlock) {
            if($loreBlock->getTag() === null) {
                $globalLoreBlocks[] = $loreBlock;
            } else {
                if(!isset($specificLoreBlocks[$loreBlock->getTag()->getName()])) {
                    $specificLoreBlocks[$loreBlock->getTag()->getName()] = [
                        "tag" => $loreBlock->getTag(),
                        "blocks" => []
                    ];
                }
                $specificLoreBlocks[$loreBlock->getTag()->getName()]["blocks"][] = $loreBlock;
            }
        }

        return $this->render('back/lore/list.html.twig', [
            'globalLoreBlocks' => $globalLoreBlocks,
            'specificLoreBlocksByTag' => $specificLoreBlocks
        ]);
    }

    /**
     * @Route("/add", name="gameBack_lore_add")
     * @Route("/update/{loreBlock}", name="gameBack_lore_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param LoreBlock|null $loreBlock
     * @return Response
     */
    public function addAndUpdateLoreBlock(EntityManagerInterface $manager, Request $request, ?LoreBlock $loreBlock)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $loreBlock = new LoreBlock();
        else
            $this->checkEntityGameContext($loreBlock);

        //Create form and handle request
        $form = $this->createForm(LoreBlockType::class, $loreBlock);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $loreBlock->setGame($this->getGame());
            $manager->persist($loreBlock);
            $this->getGame()->addLoreBlock($loreBlock);
            foreach($loreBlock->getLoreBlockElements() as $loreBlockElement) {
                $manager->persist($loreBlockElement);
                $loreBlockElement->setLoreBlock($loreBlock);
            }
            $manager->flush();
            $message = "Lore block " . $loreBlock->getTitle() . " have been created.";
            if($context == "update")
                $message = "Lore block " . $loreBlock->getTitle() . " have been updated.";
            $this->addFlash("success", $message);
            return $this->redirectToRoute('gameBack_lore_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/lore/edit.html.twig', [
            'form' => $form->createView(),
            'loreBlock' => $loreBlock,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{loreBlock}", name="gameBack_lore_delete")
     * @param LoreBlock|null $loreBlock
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function deleteLoreBlock(LoreBlock $loreBlock, EntityManagerInterface $manager)
    {
        //Remove from game
        $manager->remove($loreBlock);
        $this->getGame()->removeLoreBlock($loreBlock);

        //Flush and flash
        $manager->flush();
        $this->addFlash("success", "Block " . $loreBlock->getTitle() . " have been deleted.");
        return $this->redirectToRoute('gameBack_lore_list', ['game' => $this->getGame()->getId()]);
    }

    /**
     * @Route("/tag/add", name="gameBack_loreTag_add")
     * @Route("/tag/update/{loreTag}", name="gameBack_loreTag_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param LoreTag|null $loreTag
     * @return Response
     */
    public function addAndUpdateTag(EntityManagerInterface $manager, Request $request, ?LoreTag $loreTag)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $loreTag = new LoreTag();
        else
            $this->checkEntityGameContext($loreTag);

        //Create form and handle request
        $form = $this->createForm(LoreTagType::class, $loreTag);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $loreTag->setGame($this->getGame());
            $manager->persist($loreTag);
            $this->getGame()->addLoreTag($loreTag);
            $manager->flush();
            $message = "Tag " . $loreTag->getName() . " have been created.";
            if($context == "update")
                $message = "Resource " . $loreTag->getName() . " have been updated.";
            $this->addFlash("success", $message);
            return $this->redirectToRoute('gameBack_lore_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/lore/edit-tag.html.twig', [
            'form' => $form->createView(),
            'loreTag' => $loreTag,
            'context' => $context
        ]);
    }

    /**
     * @Route("/tag/delete/{loreTag}", name="gameBack_loreTag_delete")
     * @param LoreTag|null $loreTag
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function deleteTag(LoreTag $loreTag, EntityManagerInterface $manager)
    {
        //Remove from game
        $manager->remove($loreTag);
        $this->getGame()->removeLoreTag($loreTag);

        //Flush and flash
        $manager->flush();
        $this->addFlash("success", "Tag " . $loreTag->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_lore_list', ['game' => $this->getGame()->getId()]);
    }


}
