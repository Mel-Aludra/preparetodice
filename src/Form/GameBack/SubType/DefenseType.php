<?php

namespace App\Form\GameBack\SubType;

use App\Entity\DamageNature;
use App\Entity\Defense;
use App\Repository\DamageNatureRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DefenseType extends AbstractType
{

    private ?DamageNatureRepository $damageNatureRepository;
    private ?GameEnv $gameEnv;

    public function __construct(DamageNatureRepository $damageNatureRepository, GameEnv $gameEnv)
    {
        $this->damageNatureRepository = $damageNatureRepository;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('efficiency', IntegerType::class, [
                'label' => "Defense efficiency",
                'attr' => ['placeholder' => 'In percent. 100% means 1 attribute point equals to 1% of defense.']
            ])
            ->add('damageNature', EntityType::class, [
                'label' => "Damage nature protection",
                'class' => DamageNature::class,
                'choice_label' => "name",
                'choices' => $this->damageNatureRepository->findBy(["game" => $this->gameEnv->getGame()])
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Defense::class,
        ]);
    }
}
