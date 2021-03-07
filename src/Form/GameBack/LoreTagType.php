<?php

namespace App\Form\GameBack;

use App\Entity\LoreTag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoreTagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Lore tag name',
                'attr' => ['placeholder' => 'Each tag will be represented by a tab in game presentation']
            ])
            ->add('sort', IntegerType::class, [
                'label' => 'Lore block title',
                'attr' => ['placeholder' => 'Ordering your tags']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LoreTag::class,
        ]);
    }
}
