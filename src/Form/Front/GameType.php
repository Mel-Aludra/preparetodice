<?php

namespace App\Form\Front;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Game name',
                'attr' => ['placeholder' => 'Choose your game name', 'dataFormChecker' => "notEmpty"]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => ['placeholder' => 'Describe your game', 'dataFormChecker' => "notEmpty"]
            ])
            ->add('isActive', ChoiceType::class, [
                'label' => "Game status",
                'choices' => [
                    'Allow only game master on this game for now' => false,
                    'Allow invited players to see game dashboard and characters sheets' => true
                ]
            ])
            ->add('background', ChoiceType::class, [
                'label' => "Background image",
                'choices' => Game::BACKGROUNDS
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
