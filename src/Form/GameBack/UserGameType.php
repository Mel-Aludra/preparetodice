<?php

namespace App\Form\GameBack;

use App\Entity\UserGame;
use App\Form\GameBack\SubType\UserGameCharacterType;
use App\Service\GameEnv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserGameType extends AbstractType
{

    private ?GameEnv $gameEnv;

    public function __construct(GameEnv $gameEnv)
    {
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userGameCharacters', CollectionType::class, [
                'label' => 'User characters',
                'entry_type' => UserGameCharacterType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserGame::class,
        ]);
    }
}
