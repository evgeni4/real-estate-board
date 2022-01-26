<?php

namespace App\Form\Admin\Category;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CategoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $locale = $options['locale'];
        $builder
            ->add('translations',TranslationsType::class,
            [
                'required'=>false,
                'label'=> false,
                'fields'=>[
                    'title'=>[
                        'field_type'=> TextType::class,
                        'constraints'=>[
                            new NotBlank()
                        ]
                    ],
                    'keywords'=>[
                        'field_type'=> TextType::class,
                        'constraints'=>[
                            new NotBlank()
                        ]
                    ],
                    'description'=>[
                        'field_type'=> TextareaType::class,
                        'constraints'=>[
                            new NotBlank()
                        ]
                    ],
                ]
            ]
            )
            ->add('parent',null,
                [
                    'attr' => [
                        'class' => 'select2 form-control select2-multiple',
                        'placeholder' => 'Choose an option'
                    ],
                    'group_by' => function(Category $category) use ($locale) {
                        if ($category->getParent()){
                            return $category->getParent()->translate($locale)->getTitle();
                        }
                    }
                ])
            ->add('published',CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'locale' => true,
        ]);
    }
}
