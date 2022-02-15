<?php

namespace App\Form\Main\Search;

use App\Entity\Category;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class SearchType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EntityType::class,
                [
                    'class' => Type::class,
                    'placeholder' => false,
                    'label' => false,
                    'label_html' => true,
                    'choice_attr' => function ($choice, $key, $value) {
                        if ($value == 1) {
                            return ['class' => 'tariff-toggle', 'checked' => true];
                        }
                        return ['class' => 'tariff-toggle'];
                    },
                    'required' => false,
                    'multiple' => false,
                    'expanded' => true,
                ]
            )
            ->add('keywords', TextType::class,
                [
                    'required' => false,
                    'label' => $this->translator->trans('keywords.label'),
                    'attr' => [
                        'placeholder' => $this->translator->trans('search.key.label')
                    ]
                ])
            ->add('category', EntityType::class,
                [
                    'required' => false,
                    'label' => false,
                    'class' => Category::class,
                    'placeholder' => $this->translator->trans('all.label'),
                    'attr' => [
                        'class' => 'chosen-select no-search-select'
                    ],
                ])
            ->add('price', NumberType::class,
                [
                    'required' => false,
                    'label' => false,
                    'attr' => [
                        'class' => 'price-range',
                        'data-min' => '100',
                        'data-max' => '1000000',
                        'data-step' => '1',
                        'data-prefix' => '€',
                    ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }
}
