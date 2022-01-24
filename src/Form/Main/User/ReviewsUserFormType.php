<?php

namespace App\Form\Main\User;

use App\Entity\Reviews;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class ReviewsUserFormType extends AbstractType
{
    public function __construct(public TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required'=>false,
                'label_html'=>true,
                'label'=>$this->translator->trans('first.name.label').'* <span class="dec-icon"><i class="fas fa-user"></i></span></label>',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('email', EmailType::class, [
                'required'=>false,
                'mapped'=>false,
                'label_html'=>true,
                'label'=>$this->translator->trans('first.name.label').'* <span class="dec-icon"><i class="fas fa-envelope"></i></span></label>',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('text', TextareaType::class, [
                'required'=>false,
                'label'=>'Your comment',
                'attr'=>['placeholder'=>'Your comment'],
                'constraints'=>[
                    new NotBlank(),
                    new Length(
                        [
                            'min'=>10,
                            'minMessage'=>'Your password should be at least {{ limit }} characters',
                            'max'=>500

                        ]
                    )
                ]
            ])
            ->add('rating', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ],
                'label_html' => true,
                'choice_label' => function ($choices, $key, $value) {
                    if ($choices) {
                        return '<i class="fal fa-star"></i>' ;
                    }
                },
                'choice_attr' => function ($choices, $key, $value) {
                    return ['data-ratingtext' => $this->yourRating($key), 'class'=>'rating-'.$key];
                }, 'constraints' => [
                    new NotBlank(),
                ],
                'placeholder' => false,
                'expanded' => true,
                'multiple' => false,
            ]);
    }

    public function yourRating($key)
    {
        switch ($key) {
            case 5:
                return 'Excellent';
            case 4:
                return 'Good';
            case 3:
                return 'Average';
            case 2:
                return 'Fair';
            case 1:
                return 'Very Bad';
        }
    }

//$key == 1 ? 'Excellent' ?$key ==2: 'Good'?$key ==3:'Average'?
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reviews::class,
        ]);
    }
}
