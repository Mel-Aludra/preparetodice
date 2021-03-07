<?php

namespace App\Form\GameBack\SubType;

use App\Entity\AttributeEffect;
use App\Entity\Resource;
use App\Repository\ResourceRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttributeEffectType extends AbstractType
{

    private ?ResourceRepository $resourceRepo;
    private ?GameEnv $gameEnv;

    public function __construct(ResourceRepository $resourceRepo, GameEnv $gameEnv)
    {
        $this->resourceRepo = $resourceRepo;
        $this->gameEnv = $gameEnv;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('resource', EntityType::class, [
                'label' => "Resource altered",
                'class' => Resource::class,
                'choice_label' => "name",
                'choices' => $this->resourceRepo->findBy(["game" => $this->gameEnv->getGame()])
            ])
            ->add('isNegative', ChoiceType::class, [
                'label' => "Type of alteration",
                'choices' => ["Increase resource for each point of this attribute" => false, "Decrease resource for each point of this attribute" => true]
            ])
            ->add('valuePerPoint', IntegerType::class, [
                'label' => "Value per point",
                'attr' => ['placeholder' => 'Value of each point of this attribute']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AttributeEffect::class,
        ]);
    }
}
