<?php

namespace App\Form\GameBack\SubType;

use App\Entity\DamageNature;
use App\Entity\Entity;
use App\Entity\PotencyAugmentator;
use App\Entity\Resource;
use App\Entity\SkillHealEffect;
use App\Repository\DamageNatureRepository;
use App\Repository\PotencyAugmentatorRepository;
use App\Repository\ResourceRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillHealEffectType extends AbstractType
{

    private ?ResourceRepository $resourceRepository;
    private ?PotencyAugmentatorRepository $potencyRepository;
    private ?GameEnv $gameEnv;

    public function __construct(ResourceRepository $resourceRepository, PotencyAugmentatorRepository $potencyRepository, GameEnv $gameEnv)
    {
        $this->resourceRepository = $resourceRepository;
        $this->potencyRepository = $potencyRepository;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', IntegerType::class, [
                'label' => "Heal",
                'attr' => ['placeholder' => 'Heal value']
            ])
            ->add('calculationType', ChoiceType::class, [
                'label' => "Calculation type",
                'choices' => Entity::CALCULATION_TYPES_CHOICE
            ])
            ->add('resource', EntityType::class,  [
                'label' => "Targeted resource",
                'class' => Resource::class,
                'choice_label' => "name",
                'choices' => $this->resourceRepository->findBy(["game" => $this->gameEnv->getGame()])
            ])
            ->add('potencyAugmentator', EntityType::class, [
                'label' => "Potency augmentators",
                'class' => PotencyAugmentator::class,
                'choice_label' => 'name',
                'choices' => $this->potencyRepository->findBy(["game" => $this->gameEnv->getGame()]),
                'multiple' => true,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SkillHealEffect::class,
        ]);
    }
}
