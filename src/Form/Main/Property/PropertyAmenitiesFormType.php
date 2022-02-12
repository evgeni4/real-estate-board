<?php

namespace App\Form\Main\Property;

use App\Entity\Amenities;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyAmenitiesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amenities', EntityType::class, [
                'class' => Amenities::class,
                'label' => true,
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'mapped'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           'data_class'=>Amenities::class
        ]);
    }
}
