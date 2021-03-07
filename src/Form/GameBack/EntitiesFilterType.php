<?php

namespace App\Form\GameBack;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntitiesFilterType extends AbstractType
{

    //Filtering
    const FILTERS_ALLOWED_ELEMENTS = [
        "name" => "name",
        "description" => "description",
        "title" => "title"
    ];

    //Ordering
    const SORTING_ALLOWED_ELEMENT = [
        "id" => "Creation",
        "name" => "Name",
        "title" => "Title"
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        //Filtering elements
        foreach(self::FILTERS_ALLOWED_ELEMENTS as $modelElement => $label) {
            if(in_array($modelElement, $options["filtersElements"])) {
                $builder->add($modelElement, TextType::class, [
                    'attr' => [
                        'placeholder' => "Filter by " . $label
                    ]
                ]);
            }
        }

        //Ordering elements
        $sortingChoices = [];
        foreach(self::SORTING_ALLOWED_ELEMENT as $modelElement => $label) {
            if(in_array($modelElement, $options["sortingElements"])) {
                $sortingChoices[$label . " (AZ)"] = $modelElement . "_" . "ASC";
                $sortingChoices[$label . " (ZA)"] = $modelElement . "_" . "DESC";
            }
        }
        $builder->add('sort', ChoiceType::class, [
            'choices' => $sortingChoices
        ]);

        //Post
        $builder->add('save', SubmitType::class, ['label' => 'Create Task']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "filtersElements" => [],
            "sortingElements" => []
        ]);
    }
}
