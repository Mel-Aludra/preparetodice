<?php

namespace App\Form\GameBack;

use App\Entity\Attribute;
use App\Entity\Color;
use App\Entity\Job;
use App\Form\GameBack\SubType\AttributeEffectType;
use App\Form\GameBack\SubType\DefenseType;
use App\Repository\ColorRepository;
use App\Repository\JobRepository;
use App\Service\GameEnv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttributeType extends AbstractType
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
                'label' => 'Attribute name',
                'attr' => [
                    'placeholder' => 'Name this attribute (example: Strength, Dexterity, ...)',
                    'dataFormChecker' => "notEmpty,maxLength_255"
                ]
            ])
            ->add('abreviation', TextType::class, [
                'label' => 'Attribute abreviation',
                'attr' => [
                    'placeholder' => 'Define the abbreviation for this attribute (example: STR, DEX, ...)',
                    'dataFormChecker' => "notEmpty,maxLength_3"
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Attribute description',
                'required' => false,
                'attr' => ['placeholder' => 'Describe and explain this attribute (example: Strength increases the potency of certain physical attacks']
            ])
            ->add('maximumValue', IntegerType::class, [
                'label' => 'Attribute maximum value',
                'attr' => [
                    'placeholder' => 'Attribute will not be able to be higher than this value (example: 99)',
                    'dataFormChecker' => "notEmpty"
                ]
            ])
            ->add('defenses', CollectionType::class, [
                'label' => "Defenses",
                'entry_type' => DefenseType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('attributeEffects', CollectionType::class, [
                'label' => "Effects",
                'entry_type' => AttributeEffectType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('color', EntityType::class,  [
                'label' => "Color code of the resource",
                'class' => Color::class,
                'choice_label' => "name",
                'choices' => $this->colorRepo->findAll()
            ])
            ->add('jobs', EntityType::class, [
                'label' => "Limited to specific jobs (if jobs are checked, then only characters with one of this jobs will have this attribute)",
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
            'data_class' => Attribute::class,
        ]);
    }
}
