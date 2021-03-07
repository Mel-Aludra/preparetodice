<?php

namespace App\Form\GameBack\CharacterSubType;

use App\Entity\Consumable;
use App\Entity\InventoryConsumable;
use App\Repository\ConsumableRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryConsumableType extends AbstractType
{

    private ?ConsumableRepository $repo;
    private ?GameEnv $gameEnv;

    public function __construct(ConsumableRepository $repo, GameEnv $gameEnv)
    {
        $this->repo = $repo;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('consumable', EntityType::class, [
                'label' => "Consumable",
                'class' => Consumable::class,
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
            'data_class' => InventoryConsumable::class,
        ]);
    }
}
