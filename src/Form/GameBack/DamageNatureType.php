<?php

namespace App\Form\GameBack;

use App\Entity\DamageNature;
use App\Service\GameEnv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DamageNatureType extends AbstractType
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
                'label' => 'Damage nature name',
                'attr' => [
                    'placeholder' => 'Name this damage nature (example: Physical, Fire, ...)',
                    'dataFormChecker' => "notEmpty,maxLength_255"
                ]
            ])
            ->add('abreviation', TextType::class, [
                'label' => 'Damage nature abreviation',
                'attr' => [
                    'placeholder' => 'Define the abbreviation for this damage nature (example: PHY, FIR, ...)',
                    'dataFormChecker' => "notEmpty,maxLength_3"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DamageNature::class,
        ]);
    }
}
