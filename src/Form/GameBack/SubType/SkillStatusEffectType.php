<?php

namespace App\Form\GameBack\SubType;

use App\Entity\SkillStatusEffect;
use App\Entity\StatusEffect;
use App\Repository\StatusEffectRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillStatusEffectType extends AbstractType
{

    private ?StatusEffectRepository $statusEffectRepository;
    private ?GameEnv $gameEnv;

    public function __construct(StatusEffectRepository $statusEffectRepository, GameEnv $gameEnv)
    {
        $this->statusEffectRepository = $statusEffectRepository;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statusEffect', EntityType::class,  [
                'label' => "Status effect",
                'class' => StatusEffect::class,
                'choice_label' => "name",
                'choices' => $this->statusEffectRepository->findBy(["game" => $this->gameEnv->getGame()])
            ])
            ->add('duration', IntegerType::class, [
                'label' => "Duration",
                'attr' => [
                    'placeholder' => "Number of turns of status effect"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SkillStatusEffect::class,
        ]);
    }
}
