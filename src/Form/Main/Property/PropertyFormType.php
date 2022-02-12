<?php

namespace App\Form\Main\Property;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Amenities;
use App\Entity\Category;
use App\Entity\Country;
use App\Entity\PriceType;
use App\Entity\Property;
use App\Entity\PropertyRoomsWidget;
use App\Entity\Type;
use App\Form\Main\Property\BuildFormEventSelect\BuildFormEventSelect;
use App\Repository\AmenitiesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class PropertyFormType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator, public BuildFormEventSelect $buildFormEventSelect)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $amenities = $options['data']->getPropertyAmenities()->getValues();
        $builder
            ->add('translations', TranslationsType::class,
                [
                    'required' => false,
                    'label' => false,
                    'fields' => [
                        'title' => [
                            'field_type' => TextType::class,
//                            'locale_options'=>[
//                                'ru'=>[
//                                    'constraints'=>[
//                                        new NotBlank()
//                                    ],
//                                ]
//                            ],
                            'constraints' => [new NotBlank()],
                            'label_html' => true,
                            'label' => $this->translator->trans('title.label') . ' <span class="dec-icon"><i class="far fa-briefcase"></i></span>',

                            'attr' => [
                                'placeholder' => $this->translator->trans('title.property.label')
                            ]
                        ],
                        'description' => [
                            'field_type' => TextareaType::class,
                            'label_html' => true,
                            'attr' => ['class' => 'form-control', 'placeholder' => $this->translator->trans('description.text.label')],
                            'label' => $this->translator->trans('description.text.label'),
                            'constraints' => [
                                new NotBlank()
                            ],

                        ],
                        'keywords' => [
                            'field_type' => TextType::class,
                            'label_html' => true,
                            'attr' => ['class' => 'form-control', 'placeholder' => $this->translator->trans('keywords.maximum.label')],
                            'label' => $this->translator->trans('keywords.label') . ' <span class="dec-icon"><i class="far fa-key"></i></span>',
                            'constraints' => [
                                new NotBlank()
                            ],

                        ],
                    ]
                ]
            )
            ->add('price', TextType::class,
                [
                    'label_html' => true,
                    'label' => $this->translator->trans('price.label') . ' <span class="dec-icon"><i class="far fa-euro-sign"></i></span>',
                    'required' => false,
                    'attr' => [
                        'placeholder' => $this->translator->trans('price.label')
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => $this->translator->trans('price.label'),
                        ]),
                    ],
                ]
            )
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'required' => false,
                'label' => $this->translator->trans('country.label'),
                'placeholder' => $this->translator->trans('select.country.label'),
                'attr' => [
                    'class' => 'chosen-select no-search-select'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('select.country.label'),
                    ]),
                ],
            ])
            ->add('types', EntityType::class,
                [
                    'label' => $this->translator->trans('type.label'),
                    'required' => false,
                    'placeholder' => $this->translator->trans('select.label'),
                    'attr' => [
                        'class' => 'chosen-select no-search-select'
                    ],
                    'class' => Type::class,
                    'constraints' => [
                        new NotBlank([
                            'message' => '',
                        ]),
                    ],
                ])
            ->add('category', EntityType::class,
                [
                    'required' => false,
                    'label' => $this->translator->trans('categories.label'),
                    'class' => Category::class,
                    'placeholder' => $this->translator->trans('select.label'),
                    'attr' => [
                        'class' => 'chosen-select no-search-select'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => '',
                        ]),
                    ],
                ])
            ->add('area', TextType::class,
                [
                    'required' => false,
                    'label_html' => true,
                    'label' => $this->translator->trans('area.label') . ' <span class="dec-icon"><i class="far fa-sort-size-down-alt"></i></span>',
                    'attr' => [
                        'placeholder' => $this->translator->trans('house.area.label')
                    ],
                ])
            ->add('bedrooms', IntegerType::class,
                [
                    'required' => false,
                    'label_html' => true,
                    'label' => $this->translator->trans('bedrooms.label') . ' <span class="dec-icon"><i class="far fa-bed"></i></span>',
                    'attr' => [
                        'placeholder' => $this->translator->trans('house.bedrooms.label')
                    ],
                ])
            ->add('bathrooms', IntegerType::class,
                [
                    'required' => false,
                    'label_html' => true,
                    'label' => $this->translator->trans('bathrooms.label') . '<span class="dec-icon"><i class="far fa-bath"></i></span>',
                    'attr' => [
                        'placeholder' => $this->translator->trans('house.bathrooms.label')
                    ],
                ])
            ->add('accommodation', IntegerType::class,
                [
                    'required' => false,
                    'label_html' => true,
                    'label' => $this->translator->trans('accommodation.label') . '<span class="dec-icon"><i class="far fa-users"></i></span>',
                    'attr' => [
                        'placeholder' => $this->translator->trans('size.accommodation.label')
                    ],
                ])
            ->add('yardSize', IntegerType::class,
                [
                    'required' => false,
                    'label_html' => true,
                    'label' => $this->translator->trans('yard.size.label') . '<span class="dec-icon"><i class="far fa-trees"></i></span>',
                    'attr' => [
                        'placeholder' => $this->translator->trans('yard.size.label')
                    ],
                ])
            ->add('garage', IntegerType::class,
                [
                    'required' => false,
                    'label_html' => true,
                    'label' => $this->translator->trans('garage.label') . '<span class="dec-icon"><i class="far fa-warehouse"></i></span>',
                    'attr' => [
                        'placeholder' => $this->translator->trans('number.cars.label')
                    ],
                ])
            ->add('floors', IntegerType::class,
                [
                    'required' => false,
                    'label_html' => true,
                    'label' => $this->translator->trans('floors.label') . '<span class="dec-icon"><i class="far fa-grin-squint-tears"></i></span>',
                    'attr' => [
                        'placeholder' => $this->translator->trans('floors.label')
                    ],
                ])
            ->add('amenity', EntityType::class, [
                'class' => Amenities::class,
                'choice_attr' => function ($value, $key, $index) use ($amenities) {
                    $selected = false;
                    if ($amenities) {
                        foreach ($amenities as $key => $amenity) {
                            $item = $amenity->getProperty()->getPropertyAmenities()->getValues()[$key]->getChecked();
                            if ($amenity->getAmenity()->getId() == $value->getId() && $item == true) {
                                $selected = true;
                            }
//                            if ($amenity->getAmenity()->getId()==$value->getId()){
//                                $selected = true;
//                            }
                        }
                    }
                    return ['checked' => $selected];
                },
                'label' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => true,
                'expanded' => true,

            ])
            ->add('address', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('address.label'),
                ],
                'label_html' => true,
                'label' => $this->translator->trans('address.label') . '<span class="dec-icon"><i class="far fa-map-marker"></i></span>',
//                'constraints' => [
//                    new NotBlank()
//                ]
            ])
            ->add('longitude', TextType::class,
                [
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Map Longitude',
                    ],
                    'label_html' => true,
                    'label' => 'Longitude <span class="dec-icon"><i class="far fa-long-arrow-alt-right"></i></span>',
                ])
            ->add('latitude', TextType::class,
                [
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Map Latitude',
                    ],
                    'label_html' => true,
                    'label' => 'Latitude <span class="dec-icon"><i class="far fa-long-arrow-alt-right"></i></span>',
                ])
            ->add('images', FileType::class,
                [
                    'required' => false,
                    'attr' => ['class' => 'upload', 'accept' => 'image/*'],
                    'label' => false,
                    'mapped' => false,
                    'multiple' => true
                ]
            )
            ->add('propertyRoomsWidgets', CollectionType::class,
                [
                    'entry_type' => PropertyRoomsWidgetFormType::class,
                    'required' => false,
                    'entry_options' => [
                        'label' => '',

                    ],
                    'prototype' => true,
                    'allow_add' => true,
                    'by_reference' => false

                ])
            ->add('propertyPlans', CollectionType::class,
                [
                    'entry_type' => PropertyPlanFormType::class,
                    'required' => false,
                    'label' => false,
                    'prototype' => true,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'delete_empty' => true,
                    'by_reference' => false

                ])
            ->add('video', TextType::class,
                [
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Youtube ' . $this->translator->trans('or.label') . ' Vimeo',
                    ],
                    'label_html' => true,
                    'label' => 'Video Youtube: <span class="dec-icon"><i class="fab fa-youtube"></i></span>',
                ])
            ->add('published', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'onoffswitch-checkbox'
                ],
                'label_attr' => ['class' => 'onoffswitch-label'],
                'label_html' => true,
                'label' => '<span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>',
            ])
            ->add('roomWidgetStatus', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'onoffswitch-checkbox'
                ],
                'label_attr' => ['class' => 'onoffswitch-label'],
                'label_html' => true,
                'label' => '<span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>',
            ])
            ->add('propertyPlanStatus', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'onoffswitch-checkbox'
                ],
                'label_attr' => ['class' => 'onoffswitch-label'],
                'label_html' => true,
                'label' => '<span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>',
            ])
            ->add('videoPresentation', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'onoffswitch-checkbox'
                ],
                'label_attr' => ['class' => 'onoffswitch-label'],
                'label_html' => true,
                'label' => '<span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>',
            ])
            ->add('googleMapStatus', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'onoffswitch-checkbox'
                ],
                'label_attr' => ['class' => 'onoffswitch-label'],
                'label_html' => true,
                'label' => '<span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>',
            ])
            ->add('contactFormStatus', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'onoffswitch-checkbox'
                ],
                'label_attr' => ['class' => 'onoffswitch-label'],
                'label_html' => true,
                'label' => '<span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>',
            ]);

        $this->buildFormEventSelect->builderSelect($builder);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'allow_extra_fields' => true
        ]);
    }
}
