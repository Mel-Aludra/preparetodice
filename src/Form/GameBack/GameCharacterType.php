<?php

namespace App\Form\GameBack;

use App\Entity\CharacterStory;
use App\Entity\GameCharacter;
use App\Form\GameBack\CharacterSubType\CharacterJobType;
use App\Form\GameBack\CharacterSubType\CharacterPassiveType;
use App\Form\GameBack\CharacterSubType\CharacterSkillType;
use App\Form\GameBack\CharacterSubType\CharacterStatusEffectType;
use App\Form\GameBack\CharacterSubType\InventoryConsumableType;
use App\Form\GameBack\CharacterSubType\InventoryGearType;
use App\Form\GameBack\CharacterSubType\InventoryItemType;
use App\Form\GameBack\CharacterSubType\InventoryWeaponType;
use App\Form\GameBack\SubType\CharacterStoryType;
use App\Form\GameBack\SubType\LoreBlockElementType;
use App\Service\GameEnv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameCharacterType extends AbstractType
{

    private ?GameEnv $gameEnv;

    public function __construct(GameEnv $gameEnv)
    {
        $this->gameEnv = $gameEnv;
    }

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
                'attr' => [
                    'placeholder' => 'Describe the character',
                    'dataFormChecker' => "notEmpty"
                ]
            ]);

        //Characteristics, skills, jobs and passives
        $builder
            ->add('characterSkills', CollectionType::class, [
                'label' => 'Character skills',
                'entry_type' => CharacterSkillType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
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

        //Inventory
        $builder->add('money', IntegerType::class, [
            'label' => 'Money',
            'required' => false,
            'attr' => [
                'placeholder' => 'Amount of money owned by character',
                'dataFormChecker' => "positiveInt"
            ]
        ]);
        $builder
            ->add('inventoryItems', CollectionType::class, [
                'label' => 'Character items',
                'entry_type' => InventoryItemType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('inventoryConsumables', CollectionType::class, [
                'label' => 'Character consumables',
                'entry_type' => InventoryConsumableType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('inventoryWeapons', CollectionType::class, [
                'label' => 'Character weapons',
                'entry_type' => InventoryWeaponType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('inventoryGears', CollectionType::class, [
                'label' => 'Character gears',
                'entry_type' => InventoryGearType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;

        //Story
        $builder->add('characterStories', CollectionType::class, [
            'label' => 'Character story',
            'entry_type' => CharacterStoryType::class,
            'allow_add' => true,
            'allow_delete' => true
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GameCharacter::class,
        ]);
    }
}
