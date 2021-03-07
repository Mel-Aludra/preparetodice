<?php

namespace App\Form\GameBack;

use App\Entity\Color;
use App\Entity\Job;
use App\Entity\Resource;
use App\Repository\ColorRepository;
use App\Repository\JobRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceType extends AbstractType
{

    private ColorRepository $colorRepo;
    private ?JobRepository $jobRepo;
    private ?GameEnv $gameEnv;

    public function __construct(ColorRepository $colorRepo, JobRepository $jobRepo, GameEnv $gameEnv)
    {
        $this->gameEnv = $gameEnv;
        $this->colorRepo = $colorRepo;
        $this->jobRepo = $jobRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Resource name',
                'attr' => ['placeholder' => 'Name this resource (example: Mana, Life point, ...)', 'dataFormChecker' => "notEmpty,maxLength_255"]
            ])
            ->add('abreviation', TextType::class, [
                'label' => 'Resource abreviation',
                'attr' => ['placeholder' => 'Define abreviation for this resource (example: MA, LP, ...)', 'dataFormChecker' => "notEmpty,maxLength_3"]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Resource description',
                'attr' => ['placeholder' => 'Describe and explain this resource (example: Mana is used to launch magic skills)']
            ])
            ->add('maximumValue', IntegerType::class, [
                'label' => 'Resource maximum value',
                'attr' => ['placeholder' => 'Resource will not be able to be higher than this value (example: 999)']
            ])
            ->add('isReversedDirection', ChoiceType::class, [
                'label' => "Resource direction",
                'choices' => Resource::IS_REVERSED_DIRECTION_CHOICES
            ])
            ->add('color', EntityType::class,  [
                'label' => "Color code of the resource",
                'class' => Color::class,
                'choice_label' => "name",
                'choices' => $this->colorRepo->findAll()
            ])
            ->add('jobs', EntityType::class, [
                'label' => "Limited to specific jobs (if jobs are checked, then only characters with one of this jobs will have this resource)",
                'class' => Job::class,
                'choice_label' => 'name',
                'choices' => $this->jobRepo->findBy(["game" => $this->gameEnv->getGame()]),
                'multiple' => true,
                'expanded' => true,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Resource::class,
        ]);
    }
}
