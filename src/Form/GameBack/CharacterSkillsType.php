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

class CharacterSkillsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        //Characteristics, skills, jobs and passives
        $builder
            ->add('characterSkills', CollectionType::class, [
                'label' => 'Character skills',
                'entry_type' => CharacterSkillType::class,
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
