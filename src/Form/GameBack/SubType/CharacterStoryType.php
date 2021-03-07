<?php

namespace App\Form\GameBack\SubType;

use App\Entity\CharacterStory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterStoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class, [
                'label' => 'Element text',
                'attr' => ['placeholder' => 'Describe this element']
            ])
            ->add('isHidden', ChoiceType::class, [
                'choices' => [
                    "Only visible for game masters" => true,
                    "Visible to players who own this character" => false
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CharacterStory::class,
        ]);
    }
}
