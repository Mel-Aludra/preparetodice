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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterInventoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        //Inventory
        $builder->add('money', IntegerType::class, [
            'label' => 'Money',
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

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GameCharacter::class,
        ]);
    }
}
