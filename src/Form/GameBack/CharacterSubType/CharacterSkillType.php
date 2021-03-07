<?php

namespace App\Form\GameBack\CharacterSubType;

use App\Entity\CharacterSkill;
use App\Entity\Skill;
use App\Repository\SkillRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterSkillType extends AbstractType
{

    private ?SkillRepository $repo;
    private ?GameEnv $gameEnv;

    public function __construct(SkillRepository $repo, GameEnv $gameEnv)
    {
        $this->repo = $repo;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('skill', EntityType::class, [
                'label' => "Skill",
                'class' => Skill::class,
                'choice_label' => "name",
                'choices' => $this->repo->findBy(["game" => $this->gameEnv->getGame()])
            ])
            ->add('currentCooldown', IntegerType::class, [
                'label' => "Cooldown",
                'required' => false,
                'attr' => ['placeholder' => 'Turns number before character can use it again.']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CharacterSkill::class,
        ]);
    }
}
