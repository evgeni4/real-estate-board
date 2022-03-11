<?php

namespace App\Form\Main\PricingPlan;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\PricingPlan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class PricingPlanFormType extends AbstractType
{

    public function __construct(private TranslatorInterface $translator)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('translations', TranslationsType::class,
                [
                    'required' => false,
                    'label' => false,
                    'fields' => [
                        'title' => [
                            'field_type' => TextType::class,
                            'label'=> $this->translator->trans('title.label'),
                            'constraints' => [new NotBlank()],
                            'attr' => [
                                'placeholder' => 'Free or Basic'
                            ]
                        ],
                        'description' => [
                            'field_type' => TextareaType::class,
                            'label'=> $this->translator->trans('description.label'),
                        ],
                    ]
                ])
            ->add('price', null, [
                'required'=>false,
                'label' => $this->translator->trans('price.per.month.label')
            ])
            ->add('listingCount',IntegerType::class,
            [
                'required'=>false,
                'help'=> $this->translator->trans('listingCount.help.label'),
                'attr'=>[
                    'min'=>1
                ],
                'label'=>$this->translator->trans('listing.count.label')
            ])
            ->add('days',IntegerType::class,
                [
                    'required'=>false,
                    'attr'=>[
                        'min'=>0
                    ],
                    'label'=>$this->translator->trans('days.availability.label')
                ])
            ->add('countImage',IntegerType::class,
                [
                    'required'=>false,
                    'attr'=>[
                        'min'=>0
                    ],
                    'label'=>$this->translator->trans('image.count.label')
                ])
            ->add('recommended',CheckboxType::class,
                [
                    'required'=>false,
                    'label'=>$this->translator->trans('recommended.label')
                ])
            ->add('published',CheckboxType::class,
                [
                    'required'=>false,
                    'label'=>$this->translator->trans('published.label')
                ])
            ->add('save', SubmitType::class, [
                'label' => 'send.label'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PricingPlan::class,
        ]);
    }
}
