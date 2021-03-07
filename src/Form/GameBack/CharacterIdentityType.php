<?php

namespace App\Form\GameBack;

use App\Entity\GameCharacter;
use App\Entity\LoreBlock;
use App\Form\GameBack\CharacterSubType\CharacterAttributeType;
use App\Form\GameBack\CharacterSubType\CharacterJobType;
use App\Form\GameBack\CharacterSubType\CharacterPassiveType;
use App\Form\GameBack\CharacterSubType\CharacterResourceType;
use App\Form\GameBack\CharacterSubType\CharacterSkillType;
use App\Form\GameBack\CharacterSubType\CharacterStatusEffectType;
use App\Form\GameBack\CharacterSubType\InventoryConsumableType;
use App\Form\GameBack\CharacterSubType\InventoryGearType;
use App\Form\GameBack\CharacterSubType\InventoryItemType;
use App\Form\GameBack\CharacterSubType\InventoryWeaponType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterIdentityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //BASE
        $builder
            ->add('name', TextType::class, [
                'label' => 'Character name',
                'attr' => [
                    'placeholder' => 'Choose the name of the character',
                    'dataFormChecker' => "notEmpty"
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => ['placeholder' => 'Describe the character']
            ]);

        //Characteristics, skills, jobs and passives
        $builder
            ->add('characterPassives', CollectionType::class, [
                'label' => 'Character passives',
                'entry_type' => CharacterPassiveType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('characterJobs', CollectionType::class, [
                'label' => 'Character jobs',
                'entry_type' => CharacterJobType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;

        //Status effects
        $builder
            ->add('characterStatusEffects', CollectionType::class, [
                'label' => 'Character status effects',
                'entry_type' => CharacterStatusEffectType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GameCharacter::class,
        ]);
    }
}
