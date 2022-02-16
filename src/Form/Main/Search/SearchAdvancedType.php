<?php

namespace App\Form\Main\Search;

use App\Entity\Amenities;
use App\Entity\Category;
use App\Entity\Country;
use App\Entity\Type;
use App\Service\Property\PropertyServiceInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class SearchAdvancedType extends AbstractType
{
    public function __construct(public BuildFormEventAdvancedSearch $advancedSearch, private TranslatorInterface $translator, private PropertyServiceInterface $propertyService)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $numbers = $this->propertyService->minMaxNumber();
        $builder
            ->add('keywords', TextType::class,
                [
                    'required' => false,
                    'label' => false,
                    'attr' => [
                        'placeholder' => $this->translator->trans('search.key.label')
                    ]
                ])
            ->add('type', EntityType::class,
                [
                    'label' => false,
                    'required' => false,
                    'placeholder' => $this->translator->trans('type.label'),
                    'attr' => [
                        'class' => 'chosen-select no-search-select'
                    ],
                    'class' => Type::class,
                ])
            ->add('price', NumberType::class,
                [
                    'required' => false,
                    'label' => false,
                    'attr' => [
                        'class' => 'price-range-double',
                        'data-min' => $numbers['min'],
                        'data-max' => $numbers['max'],
                        'data-step' => '1000',
                        'data-prefix' => '€',
                    ]
                ])
            ->add('category', EntityType::class,
                [
                    'required' => false,
                    'label' => false,
                    'class' => Category::class,
                    'placeholder' => $this->translator->trans('categories.label'),
                    'attr' => [
                        'class' => 'chosen-select no-search-select'
                    ]
                ])
//            ->add('country', EntityType::class, [
//                'class' => Country::class,
//                'required' => false,
//                'label' => false,
//                'placeholder' => $this->translator->trans('select.country.label'),
//                'attr' => [
//                    'class' => 'chosen-select no-search-select'
//                ]
//            ])
            ->add('bedrooms', ChoiceType::class,
                [
                    'required' => false,
                    'label' => false,
                    'placeholder' => $this->translator->trans('select.label'),
                    'attr' => [
                        'class' => 'chosen-select on-radius no-search-select',
                    ],
                    'choices' => [$this->numbers($numbers['bedrooms'])]
                ])
            ->add('bathrooms', ChoiceType::class,
                [
                    'required' => false,
                    'label' => false,
                    'placeholder' => $this->translator->trans('select.label'),
                    'attr' => [
                        'class' => 'chosen-select on-radius no-search-select',
                    ],
                    'choices' => [$this->numbers($numbers['bathrooms'])]
                ])
            ->add('floors', ChoiceType::class,
                [
                    'required' => false,
                    'label' => false,
                    'placeholder' => $this->translator->trans('select.label'),
                    'attr' => [
                        'class' => 'chosen-select on-radius no-search-select'
                    ],
                    'choices' => [$this->numbers($numbers['floors'])]
                ])
            ->add('referenceNumber', IntegerType::class,
                [
                    'required' => false,
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Ref№',
                        'min' => 1
                    ],
                ])
            ->add('area', TextType::class,
                [
                    'required' => false,
                    'label_html' => true,
                    'label' => false,
                    'attr' => [
                        'class' => 'price-range-double',
                        'data-min' => $numbers['areaMin'],
                        'data-max' => $numbers['areaMax'],
                        'data-step' => '1',
                        'data-prefix' => 'm2 - '
                    ],
                ])
            ->add('amenity', EntityType::class, [
                'class' => Amenities::class,
                'label' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => true,
                'expanded' => true,

            ])
            ->add('search',SubmitType::class,[
                'label_html'=>true,
                'label'=>$this->translator->trans('search.label'),
                'attr'=>[
                    'class'=>'btn small-btn float-btn color-bg'
                ]
            ])
        ->setMethod('GET');
//       $this->advancedSearch->builder($builder);
    }

    function numbers($param): array
    {
        $number = [];
        for ($i = 1; $i <= $param; $i++) {
            $number[$i] = $i;
        }
        return $number;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }
}
