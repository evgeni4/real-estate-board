<?php

namespace App\Form\Main\Property;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Amenities;
use App\Entity\PropertyRoomsWidget;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class PropertyRoomsWidgetFormType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('translations',TranslationsType::class,
            [
                'required' => false,
                'label' => false,
                'fields' => [
                    'title' => [
                        'field_type' => TextType::class,
                        'label_html'=>true,
                        'row_attr'=>['class'=>'col-sm-6'],
                        'label' =>$this->translator->trans('room.title.label').' <span class="dec-icon"><i  class="fal fa-layer-group"></i></span>',
                        'attr' => [
                            'placeholder' =>$this->translator->trans('room.title.placeholder.label')
                        ]
                    ],
                    'room' => [
                        'field_type' => TextType::class,
                        'label_html'=>true,
                        'row_attr'=>['class'=>'col-sm-6'],
                        'label' =>$this->translator->trans('room.additional.label').' <span class="dec-icon"><i class="fal fa-layer-plus"></i></span>',
                        'attr' => [
                            'placeholder' => $this->translator->trans('room.additional.placeholder.label')
                        ]
                    ],
                    'details' => [
                        'field_type' => TextareaType::class,
                        'row_attr'=>['class'=>'col-sm-12'],
                        'label' =>$this->translator->trans('room.details.label'),
                        'attr'=>[
                            'placeholder'=>$this->translator->trans('room.details.placeholder.label'),
                            'spellcheck'=>'false',
                            'cols'=>40,
                            'rows'=>3,
                            'style'=>'height: 175px;margin-bottom: 10px'
                        ]
                    ],
                ]
            ])
            ->add('amenityRoom', EntityType::class, [
                'class' => Amenities::class,
                'label_html' => true,
                'label' => '<label >'.$this->translator->trans('amenities.label').'</label>',
                'row_attr'=>['class'=>'col-sm-6 fl-wrap filter-tags no-list-style ds-tg'],
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'expanded' => true,

            ])
            ->add('imageRoom', FileType::class,
                [
                    'required'=>false,
                    'label_html'=>true,
                    'row_attr'=>['class'=>'col-sm-6 center-block  listsearch-input-item fl-wrap fuzone','style'=>'width: 350px;height: 200px'],
                    'label'=> '<div class="fu-text">
                            <span><i class="far fa-cloud-upload-alt"></i>'.$this->translator->trans('drop.files.label').'</span>
                            <div class="photoUpload-files fl-wrap"></div>
                        </div>',
                    'attr' => ['class' => 'upload','accept'=>'image/*'],

                ]
            )
            ->add('published',CheckboxType::class,
            [
                'required' => false,
                'row_attr'=>['style'=>'width:110px; float:right','class'=>'col-sm-6 right'],
                'attr' => [
                    'class' => 'onoffswitch-checkbox'
                ],
                'label_attr' => ['class' => 'onoffswitch-label'],
                'label_html' => true,
                'label' => '<span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PropertyRoomsWidget::class,
        ]);
    }
}
