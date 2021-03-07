<?php

namespace App\Form\GameBack\SubType;

use App\Entity\LoreBlockElement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoreBlockElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Element title',
                'attr' => ['placeholder' => 'Name this element']
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Element text',
                'attr' => ['placeholder' => 'Describe this element']
            ])
            ->add('accessType', ChoiceType::class, [
                'choices' => [
                    "Only visible for game masters" => LoreBlockElement::HIDDEN_ACCESS,
                    "Visible to those who are related to the element" => LoreBlockElement::RELATED_ACCESS,
                    "Visible for everyone" => LoreBlockElement::PUBLIC_ACCESS
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LoreBlockElement::class,
        ]);
    }
}
