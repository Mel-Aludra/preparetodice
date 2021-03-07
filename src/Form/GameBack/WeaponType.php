<?php

namespace App\Form\GameBack;

use App\Entity\Job;
use App\Entity\Weapon;
use App\Form\GameBack\SubType\SkillCostType;
use App\Form\GameBack\SubType\SkillDamageEffectType;
use App\Form\GameBack\SubType\SkillGainType;
use App\Form\GameBack\SubType\SkillHealEffectType;
use App\Form\GameBack\SubType\SkillStatusEffectType;
use App\Repository\JobRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeaponType extends AbstractType
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
                'label' => 'Weapon name',
                'attr' => [
                    'placeholder' => 'Name this weapon',
                    'dataFormChecker' => "notEmpty"
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Weapon description',
                'attr' => ['placeholder' => 'Describe this weapon']
            ])
            ->add('skillCosts', CollectionType::class, [
                'label' => 'Costs',
                'entry_type' => SkillCostType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('skillGains', CollectionType::class, [
                'label' => 'Gains',
                'entry_type' => SkillGainType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('skillDamageEffects', CollectionType::class, [
                'label' => 'Damage effects',
                'entry_type' => SkillDamageEffectType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('skillHealEffects', CollectionType::class, [
                'label' => 'Heal effects',
                'entry_type' => SkillHealEffectType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('skillStatusEffects', CollectionType::class, [
                'label' => 'Status effects',
                'entry_type' => SkillStatusEffectType::class,
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
            'data_class' => Weapon::class,
        ]);
    }
}
