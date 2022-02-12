<?php

namespace App\Form\Main\Property;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\PriceType;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PriceTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('translations',TranslationsType::class,
            [
                'required'=>false,
                'label' => false,
                'fields'=>[
                    'title'=>[
                        'field_type'=>TextType::class,
                        'constraints' => [new NotBlank()],
                        'attr' => [
                            'placeholder' => 'For night, for month'
                        ]
                    ]
                ]
            ])
            ->add('type',EntityType::class,[
                'required'=>false,
                'class'=>Type::class,
                'constraints' => [new NotBlank()],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PriceType::class,
        ]);
    }
}
