<?php

namespace App\Form\GameBack;

use App\Entity\Gear;
use App\Entity\Job;
use App\Form\GameBack\SubType\AttributeAlterationType;
use App\Form\GameBack\SubType\DamageOverTimeType;
use App\Form\GameBack\SubType\HealOverTimeType;
use App\Form\GameBack\SubType\ResourceAlterationType;
use App\Repository\JobRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GearType extends AbstractType
{

    private ?JobRepository $jobRepo;
    private ?GameEnv $gameEnv;

    public function __construct(JobRepository $jobRepo, GameEnv $gameEnv)
    {
        $this->jobRepo = $jobRepo;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, [
                'label' => 'Gear name',
                'attr' => [
                    'placeholder' => 'Name this gear',
                    'dataFormChecker' => "notEmpty"
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Gear description',
                'attr' => ['placeholder' => 'Describe this gear']
            ])
            ->add('attributeAlterations', CollectionType::class, [
                'label' => 'Attribute alterations',
                'entry_type' => AttributeAlterationType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('resourceAlterations', CollectionType::class, [
                'label' => 'Resource alterations',
                'entry_type' => ResourceAlterationType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('damageOverTimes', CollectionType::class, [
                'label' => 'Damage over time',
                'entry_type' => DamageOverTimeType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('healOverTimes', CollectionType::class, [
                'label' => 'Heal over time',
                'entry_type' => HealOverTimeType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('jobs', EntityType::class, [
                'label' => "Limited to specific jobs",
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
            'data_class' => Gear::class,
        ]);
    }
}
