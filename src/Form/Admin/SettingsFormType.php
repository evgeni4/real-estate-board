<?php

namespace App\Form\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Settings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SettingsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('translations', TranslationsType::class,
                [
                    'label' => false,
                    'required' => false,
                    'fields' => [
                        'siteName' => [
                            'field_type' => TextType::class,
                            'constraints' => [
                                new NotBlank(),
                                new Length(
                                    ['min' => 5]
                                )
                            ],
                        ],
                        'metaKeywords' => [
                            'field_type' => TextType::class,
                            'constraints' => [
                                new NotBlank(),
                                new Length(
                                    ['min' => 5]
                                )
                            ],
                        ],
                        'metaDescription' => [
                            'field_type' => TextareaType::class,
                            'constraints' => [
                                new NotBlank(),
                                new Length(
                                    ['min' => 5]
                                )
                            ],
                        ],
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Settings::class,
        ]);
    }
}