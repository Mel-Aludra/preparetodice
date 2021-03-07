<?php

namespace App\Form\GameBack;

use App\Entity\Action;
use App\Form\GameBack\SubType\SkillCostType;
use App\Form\GameBack\SubType\SkillDamageEffectType;
use App\Form\GameBack\SubType\SkillGainType;
use App\Form\GameBack\SubType\SkillHealEffectType;
use App\Form\GameBack\SubType\SkillStatusEffectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Action name',
                'attr' => [
                    'placeholder' => 'Name this action',
                    'dataFormChecker' => "notEmpty"
                ]
            ])
            ->add('skillCosts', CollectionType::class, [
                'label' => 'Action costs',
                'entry_type' => SkillCostType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('skillGains', CollectionType::class, [
                'label' => 'Action gains',
                'entry_type' => SkillGainType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('skillDamageEffects', CollectionType::class, [
                'label' => 'Action damage effects',
                'entry_type' => SkillDamageEffectType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('skillHealEffects', CollectionType::class, [
                'label' => 'Action heal effects',
                'entry_type' => SkillHealEffectType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('skillStatusEffects', CollectionType::class, [
                'label' => 'Action status effects',
                'entry_type' => SkillStatusEffectType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Action::class,
        ]);
    }
}
