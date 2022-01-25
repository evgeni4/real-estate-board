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
                'label'=>$this->translator->trans('first.name.label').' '.$this->translator->trans('and.label').' '.$this->translator->trans('last.name.label').'* <span class="dec-icon"><i class="fas fa-user"></i></span></label>',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('email', EmailType::class, [
                'required'=>false,
                'mapped'=>false,
                'label_html'=>true,
                'label'=>'Email * <span class="dec-icon"><i class="fas fa-envelope"></i></span></label>',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('text', TextareaType::class, [
                'required'=>false,
                'label'=> $this->translator->trans('your.review.label'),
                'attr'=>['placeholder'=>$this->translator->trans('your.review.label')],
                'constraints'=>[
                    new NotBlank(),
                    new Length(
                        [
                            'min'=>10,
                            'minMessage'=>$this->translator->trans('min.message.reviews.label').' {{ limit }} '.$this->translator->trans('characters.label').'!',
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
                        return "<span class='rating fal fa-star' id='star$key' onclick=add(this,'" . $key . "')></span>";
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
                return $this->translator->trans('excellent.label');
            case 4:
                return $this->translator->trans('good.label');
            case 3:
                return $this->translator->trans('average.label');
            case 2:
                return $this->translator->trans('fair.label');
            case 1:
                return $this->translator->trans('very.bad.label');
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
