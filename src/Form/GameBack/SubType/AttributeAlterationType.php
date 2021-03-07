<?php

namespace App\Form\GameBack\SubType;

use App\Entity\Attribute;
use App\Entity\AttributeAlteration;
use App\Entity\Entity;
use App\Repository\AttributeRepository;
use App\Service\GameEnv;
use \Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttributeAlterationType extends AbstractType
{
    private ?AttributeRepository $attributeRepository;
    private ?GameEnv $gameEnv;

    public function __construct(AttributeRepository $attributeRepository, GameEnv $gameEnv)
    {
        $this->attributeRepository = $attributeRepository;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isNegative', ChoiceType::class, [
                'label' => "Type of alteration",
                'choices' => [
                    "Malus" => true,
                    "Bonus" => false
                ]
            ])
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
            ->add('attribute', EntityType::class,  [
                'label' => "Targeted attribute",
                'class' => Attribute::class,
                'choice_label' => "name",
                'choices' => $this->attributeRepository->findBy(["game" => $this->gameEnv->getGame()])
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AttributeAlteration::class,
        ]);
    }
}
