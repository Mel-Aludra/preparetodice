<?php

namespace App\Form\GameBack\CharacterSubType;

use App\Entity\CharacterStatusEffect;
use App\Entity\StatusEffect;
use App\Repository\StatusEffectRepository;
use App\Service\GameEnv;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterStatusEffectType extends AbstractType
{

    private ?StatusEffectRepository $repo;
    private ?GameEnv $gameEnv;

    public function __construct(StatusEffectRepository $repo, GameEnv $gameEnv)
    {
        $this->repo = $repo;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statusEffect', EntityType::class, [
                'label' => "Status effect",
                'class' => StatusEffect::class,
                'choice_label' => "name",
                'choices' => $this->repo->findBy(["game" => $this->gameEnv->getGame()])
            ])
            ->add('remainingTurns', IntegerType::class, [
                'label' => "Remaining turns",
                'required' => false,
                'attr' => ['placeholder' => 'Turns before status effect disappear (let empty for unending status effect).']
            ])
            ->add('wipeIfReset', ChoiceType::class, [
                'label' => "Healing function reaction",
                'choices' => [
                    'Wipe if global healing function is used' => true,
                    'Don\'t wipe if global healing function is used'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CharacterStatusEffect::class,
        ]);
    }
}
