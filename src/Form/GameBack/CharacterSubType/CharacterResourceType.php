<?php

namespace App\Form\GameBack\CharacterSubType;

use App\Entity\CharacterResource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterResourceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentValue', IntegerType::class, [
                'label' => "Current value",
                'attr' => ['placeholder' => "Current value of character resource"]
            ])
            ->add('value', IntegerType::class, [
                'label' => "Basis value",
                'attr' => ['placeholder' => "Value of character resource"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CharacterResource::class,
        ]);
    }
}
