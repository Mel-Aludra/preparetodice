<?php

namespace App\Form\GameBack\CharacterSubType;

use App\Entity\CharacterJob;
use App\Entity\Job;
use App\Repository\JobRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterJobType extends AbstractType
{

    private ?JobRepository $repo;
    private ?GameEnv $gameEnv;

    public function __construct(JobRepository $repo, GameEnv $gameEnv)
    {
        $this->repo = $repo;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('job', EntityType::class, [
                'label' => "Job",
                'class' => Job::class,
                'choice_label' => "name",
                'choices' => $this->repo->findBy(["game" => $this->gameEnv->getGame()])
            ])
            ->add('isActive', ChoiceType::class, [
                'label' => "Job active",
                'choices' => [
                    "Job is active, the character can use elements related to this job (weapons, gears, ...)" => true,
                    "Job is inactive, the character can't use elements related to this job (weapons, gears, ...)" => false
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CharacterJob::class,
        ]);
    }
}
