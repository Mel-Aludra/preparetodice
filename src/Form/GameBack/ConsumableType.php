<?php

namespace App\Form\GameBack;

use App\Entity\Consumable;
use App\Form\GameBack\SubType\SkillDamageEffectType;
use App\Form\GameBack\SubType\SkillHealEffectType;
use App\Form\GameBack\SubType\SkillStatusEffectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsumableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Consumable name',
                'attr' => [
                    'placeholder' => 'Name this consumable',
                    'dataFormChecker' => "notEmpty"
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Consumable description',
                'attr' => ['placeholder' => 'Describe this consumable']
            ])
            ->add('skillDamageEffects', CollectionType::class, [
                'label' => 'Damage effects',
                'entry_type' => SkillDamageEffectType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('skillHealEffects', CollectionType::class, [
                'label' => 'Heal effects',
                'entry_type' => SkillHealEffectType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('skillStatusEffects', CollectionType::class, [
                'label' => 'Status effects',
                'entry_type' => SkillStatusEffectType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consumable::class,
        ]);
    }
}
