<?php

namespace App\Form\Admin\Type;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('translations',TranslationsType::class,
            [
                'required'=>false,
                'label'=>false,
                'fields'=>[
                    'title'=>[
                        'field_type'=>TextType::class,
                        'constraints'=>[
                            new NotBlank()
                        ]
                    ]
                ]
            ])
            ->add('published',CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Type::class,
        ]);
    }
}
