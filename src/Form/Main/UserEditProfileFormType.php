<?php

namespace App\Form\Main;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserEditProfileFormType extends AbstractType
{
    public function __construct(public TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class,
                [
                    'required' => false,
                    'label_html' => true,
                    'label' => $this->translator->trans('first.name.label').' <span class="dec-icon"><i class="far fa-user"></i></span>',
                    'constraints' => [
                        new NotBlank(),
                    ],

                ]
            )
            ->add('lastName', TextType::class,
                [
                    'required' => false,
                    'label_html' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'label' => $this->translator->trans('last.name.label').' <span class="dec-icon"><i class="fas fa-user"></i></span>'
                ]
            )
            ->add('phone', TextType::class,
                [
                    'required' => false,
                    'attr'=>['placeholder'=>'359 0888 123456'],
                    'constraints' => [
                        new NotBlank([
                            'message' => $this->translator->trans('enter.phone.label'),
                        ]),
                        new Regex('/[0-9]+$/', $this->translator->trans('invalid.phone.format.label'))
//                        new Length([
//                            'min' => 6,
//                            'minMessage' => $this->translator->trans('password.length.label').' {{ limit }} '.$this->translator->trans('characters.label'),
//                            // max length allowed by Symfony for security reasons
//                            'max' => 4096,
//                        ]),
                    ],
                    'label_html' => true,
                    'label' => $this->translator->trans('phone.label').' <span class="dec-icon"><i class="far fa-phone"></i> </span>'
                ]
            )
            ->add('agency', TextType::class,
                [
                    'required' => false,
                    'label_html' => true,
                    'label' => $this->translator->trans('agency.label').' <span class="dec-icon"><i class="far fa-home-lg-alt"></i> </span>'
                ]
            )
            ->add('aboutMe', TextareaType::class,
                [
                    'required' => false,
                    'attr'=>['style'=>'margin-bottom:20px;'],
                    'label' => $this->translator->trans('about.me.label')
                ]
            )
            ->add('newImage',FileType::class,
            [
                'required'=>false,
                'attr'=>['class'=>'upload'],
                'label_html'=>true,
                'label'=>'<span>'.$this->translator->trans('new.photo.label').'</span>',
                'mapped'=>false
            ]
            )
        ;
            //->add('password');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
