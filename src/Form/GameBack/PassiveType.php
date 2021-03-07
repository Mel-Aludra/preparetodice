<?php

namespace App\Form\GameBack;

use App\Entity\Passive;
use App\Form\GameBack\SubType\AttributeAlterationType;
use App\Form\GameBack\SubType\DamageOverTimeType;
use App\Form\GameBack\SubType\HealOverTimeType;
use App\Form\GameBack\SubType\ResourceAlterationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PassiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Passive name',
                'attr' => [
                    'placeholder' => 'Name this passive',
                    'dataFormChecker' => "notEmpty"
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Passive description',
                'attr' => ['placeholder' => 'Describe this passive']
            ])
            ->add('attributeAlterations', CollectionType::class, [
                'label' => 'Attribute alterations',
                'entry_type' => AttributeAlterationType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('resourceAlterations', CollectionType::class, [
                'label' => 'Resource alterations',
                'entry_type' => ResourceAlterationType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('damageOverTimes', CollectionType::class, [
                'label' => 'Damage over time',
                'entry_type' => DamageOverTimeType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('healOverTimes', CollectionType::class, [
                'label' => 'Heal over time',
                'entry_type' => HealOverTimeType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Passive::class,
        ]);
    }
}
