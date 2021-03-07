<?php

namespace App\Form\GameBack\SubType;

use App\Entity\Entity;
use App\Entity\Resource;
use App\Entity\SkillCost;
use App\Repository\ResourceRepository;
use App\Service\GameEnv;
use \Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillCostType extends AbstractType
{
    private ?ResourceRepository $resourceRepository;
    private ?GameEnv $gameEnv;

    public function __construct(ResourceRepository $resourceRepository, GameEnv $gameEnv)
    {
        $this->resourceRepository = $resourceRepository;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', IntegerType::class, [
                'label' => "Cost value",
                'attr' => [
                    'placeholder' => 'Cost value',
                    'dataFormChecker' => "notEmpty,positiveInteger"
                ]
            ])
            ->add('calculationType', ChoiceType::class, [
                'label' => "Calculation type",
                'choices' => Entity::CALCULATION_TYPES_CHOICE
            ])
            ->add('resource', EntityType::class,  [
                'label' => "Targeted resource",
                'class' => Resource::class,
                'choice_label' => "name",
                'choices' => $this->resourceRepository->findBy(["game" => $this->gameEnv->getGame()])
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SkillCost::class,
        ]);
    }
}
