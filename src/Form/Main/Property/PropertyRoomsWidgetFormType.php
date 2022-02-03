<?php

namespace App\Form\Main\Property;

use App\Entity\PropertyRoomsWidget;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyRoomsWidgetFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,
            [
                'required'=>false,
                'label_html'=>true,
                'row_attr'=>['class'=>'col-sm-6'],
                'label'=>'Room Title: <span class="dec-icon"><i  class="fal fa-layer-group"></i></span>',
                'attr'=>[
                    'placeholder'=>'Standard Family Room'
                ]
            ])
            ->add('room',TextType::class,
                [
                    'required'=>false,
                    'label_html'=>true,
                    'row_attr'=>['class'=>'col-sm-6'],
                    'label'=>'Additional Room: <span class="dec-icon"><i class="fal fa-layer-plus"></i></span>',
                    'attr'=>[
                        'placeholder'=>'Example: Sauna'
                    ]
                ])
            ->add('details',TextareaType::class,
                [
                    'required'=>false,
                    'row_attr'=>['class'=>'col-sm-12'],
                    'label'=>'Room Details',
                    'attr'=>[
                        'placeholder'=>'Details',
                        'spellcheck'=>'false',
                        'cols'=>40,
                        'rows'=>3,
                        'style'=>'height: 175px;margin-bottom: 10px'
                    ]
                ])
            ->add('published',CheckboxType::class,
            [
                'required' => false,
                'row_attr'=>['style'=>'width:80px'],
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
