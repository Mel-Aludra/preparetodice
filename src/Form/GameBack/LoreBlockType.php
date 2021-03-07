<?php

namespace App\Form\GameBack;

use App\Entity\LoreBlock;
use App\Entity\LoreTag;
use App\Form\GameBack\SubType\LoreBlockElementType;
use App\Repository\ColorRepository;
use App\Repository\JobRepository;
use App\Repository\LoreTagRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoreBlockType extends AbstractType
{

    private ?LoreTagRepository $loreTagsRepo;
    private ?GameEnv $gameEnv;


    public function __construct(LoreTagRepository $loreTagsRepo, GameEnv $gameEnv)
    {
        $this->gameEnv = $gameEnv;
        $this->loreTagsRepo = $loreTagsRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Lore block title',
                'attr' => ['placeholder' => 'Name this lore block']
            ])
            ->add('accessType', ChoiceType::class, [
                'choices' => [
                    "Only visible for game masters" => LoreBlock::HIDDEN_ACCESS,
                    "Visible to those who are related to the element" => LoreBlock::RELATED_ACCESS,
                    "Visible for everyone" => LoreBlock::PUBLIC_ACCESS
                ]
            ])
            ->add('tag', EntityType::class, [
                'class' => LoreTag::class,
                'choice_label' => 'name',
                'choices' => $this->loreTagsRepo->findBy(["game" => $this->gameEnv->getGame()])
            ])
            ->add('loreBlockElements', CollectionType::class, [
                'label' => 'Elements',
                'entry_type' => LoreBlockElementType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LoreBlock::class,
        ]);
    }
}
