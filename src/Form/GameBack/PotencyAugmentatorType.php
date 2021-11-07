<?php

namespace App\Form\GameBack;

use App\Entity\Attribute;
use App\Entity\PotencyAugmentator;
use App\Repository\AttributeRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PotencyAugmentatorType extends AbstractType
{

    private ?AttributeRepository $repo;
    private ?GameEnv $gameEnv;

    public function __construct(AttributeRepository $repo, GameEnv $gameEnv)
    {
        $this->repo = $repo;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Name",
                'attr' => [
                    'placeholder' => "Potency augmentator name (example: Dexterity boost)",
                    'dataFormChecker' => "notEmpty,maxLength_255"
                ]
            ])
            ->add('attribute', EntityType::class, [
                'label' => "Attribute",
                'class' => Attribute::class,
                'choice_label' => "name",
                'choices' => $this->repo->findBy(["game" => $this->gameEnv->getGame()])
            ])
            ->add('type', ChoiceType::class, [
                'label' => "Augmentator type",
                'choices' => PotencyAugmentator::TYPES_CHOICE
            ])
            ->add('percentCeiling', IntegerType::class, [
                'label' => "Percent ceiling",
                'required' => false,
                'attr' => [
                    'placeholder' => "Maximum base percent of value (example: if 100 is indicated, it means that the effect will not be able to exceed double its initial damage)"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PotencyAugmentator::class,
        ]);
    }
}
