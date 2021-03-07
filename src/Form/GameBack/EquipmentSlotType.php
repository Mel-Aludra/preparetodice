<?php

namespace App\Form\GameBack;

use App\Entity\EquipmentSlot;
use App\Service\GameEnv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentSlotType extends AbstractType
{

    private ?GameEnv $gameEnv;


    public function __construct(GameEnv $gameEnv)
    {
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Equipment slot name',
                'attr' => [
                    'placeholder' => 'Name this equipment slot (example: Head, Body, ...)',
                    'dataFormChecker' => "notEmpty,maxLength_255"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EquipmentSlot::class,
        ]);
    }
}
