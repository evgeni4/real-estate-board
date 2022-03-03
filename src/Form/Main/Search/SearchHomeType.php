<?php

namespace App\Form\Main\Search;

use App\Entity\Category;
use App\Entity\Type;
use App\Service\Property\PropertyServiceInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class SearchHomeType extends AbstractType
{
    public function __construct(private UrlGeneratorInterface $urlGenerator,private TranslatorInterface $translator,private PropertyServiceInterface $propertyService)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('keywords', TextType::class,
                [
                    'required' => false,
                    'label' => false,
                    'attr' => [
                        'placeholder' => $this->translator->trans('looking.for.label')
                    ]
                ])
            ->add('type', EntityType::class,
                [
                    'class' => Type::class,
                    'placeholder' => $this->translator->trans('select.label'),
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'class' => 'chosen-select no-search-select'
                    ],
                ]
            )
            ->add('category', EntityType::class,
                [
                    'required' => false,
                    'label' => false,
                    'class' => Category::class,
                    'placeholder' => $this->translator->trans('select.label'),
                    'attr' => [
                        'class' => 'chosen-select no-search-select'
                    ],
                ])
            ->setMethod('get')
            ->setAction($this->urlGenerator->generate('main_listing_all'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
