<?php

namespace App\Form\GameBack\CharacterSubType;

use App\Entity\CharacterPassive;
use App\Entity\CharacterSkill;
use App\Entity\Passive;
use App\Entity\Skill;
use App\Repository\PassiveRepository;
use App\Repository\SkillRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterPassiveType extends AbstractType
{

    private ?PassiveRepository $repo;
    private ?GameEnv $gameEnv;

    public function __construct(PassiveRepository $repo, GameEnv $gameEnv)
    {
        $this->repo = $repo;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('passive', EntityType::class, [
                'label' => "Passive",
                'class' => Passive::class,
                'choice_label' => "name",
                'choices' => $this->repo->findBy(["game" => $this->gameEnv->getGame()])
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CharacterPassive::class,
        ]);
    }
}
