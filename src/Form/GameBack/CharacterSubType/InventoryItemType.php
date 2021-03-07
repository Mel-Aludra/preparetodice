<?php

namespace App\Form\GameBack\CharacterSubType;

use App\Entity\InventoryItem;
use App\Entity\Item;
use App\Repository\ItemRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryItemType extends AbstractType
{

    private ?ItemRepository $repo;
    private ?GameEnv $gameEnv;

    public function __construct(ItemRepository $repo, GameEnv $gameEnv)
    {
        $this->repo = $repo;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('item', EntityType::class, [
                'label' => "Item",
                'class' => Item::class,
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
            'data_class' => InventoryItem::class,
        ]);
    }
}
