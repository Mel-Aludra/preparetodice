<?php

namespace App\Form\GameBack\CharacterSubType;

use App\Entity\Gear;
use App\Entity\InventoryGear;
use App\Repository\GearRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryGearType extends AbstractType
{

    private ?GearRepository $repo;
    private ?GameEnv $gameEnv;

    public function __construct(GearRepository $repo, GameEnv $gameEnv)
    {
        $this->repo = $repo;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gear', EntityType::class, [
                'label' => "Gear",
                'class' => Gear::class,
                'choice_label' => "name",
                'choices' => $this->repo->findBy(["game" => $this->gameEnv->getGame()])
            ])
            ->add('quantity', IntegerType::class, [
                'label' => "Quantity",
                'required' => false,
                'attr' => ['placeholder' => 'Quantity in character inventory']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InventoryGear::class,
        ]);
    }
}
