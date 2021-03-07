<?php

namespace App\Form\GameBack\CharacterSubType;

use App\Entity\InventoryWeapon;
use App\Entity\Weapon;
use App\Repository\WeaponRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryWeaponType extends AbstractType
{

    private ?WeaponRepository $repo;
    private ?GameEnv $gameEnv;

    public function __construct(WeaponRepository $repo, GameEnv $gameEnv)
    {
        $this->repo = $repo;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('weapon', EntityType::class, [
                'label' => "Weapon",
                'class' => Weapon::class,
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
            'data_class' => InventoryWeapon::class,
        ]);
    }
}
