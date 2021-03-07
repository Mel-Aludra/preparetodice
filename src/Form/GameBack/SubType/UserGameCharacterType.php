<?php

namespace App\Form\GameBack\SubType;

use App\Entity\GameCharacter;
use App\Entity\UserGameCharacter;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserGameCharacterType extends AbstractType
{

    private ?GameEnv $gameEnv;

    public function __construct(GameEnv $gameEnv)
    {
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gameCharacter', EntityType::class,  [
                'label' => "Character",
                'class' => GameCharacter::class,
                'choice_label' => "name",
                'choices' => $this->gameEnv->getGame()->getGameCharacters()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserGameCharacter::class,
        ]);
    }
}
