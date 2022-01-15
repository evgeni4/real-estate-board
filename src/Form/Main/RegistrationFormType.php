<?php

namespace App\Form\Main;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationFormType extends AbstractType
{
    public function __construct(public TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('email',TextType::class,
            [
                'required'=>false,
                'label_html' => true,
                'label'=>'Email * <span class="dec-icon"><i class="fal fa-user"></i></span>'
            ]
            )
            ->add('agreeTerms', CheckboxType::class, [
                'required'=>false,
                'mapped' => false,
                'label_html' => true,
                'label'=>$this->translator->trans('agree.label').' <a href="listing3.html#" mb-checked="1" data-tip="">Privacy Policy</a>'.$this->translator->trans('and.label').' <a href="listing3.html#" mb-checked="1" data-tip="">Terms and Conditions</a>',
                'constraints' => [
                    new IsTrue([
                        'message' => $this->translator->trans('agree.message.label'),
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'required'=>false,
                'type' => PasswordType::class,
                'first_options'=>[
                    'help' => 'Min 6 characters!',
                    'label_html' => true,
                    'label'=>$this->translator->trans('password.label').'  * <span class="dec-icon"><i class="fal fa-key"></i></span>',
                    'attr' => ['autocomplete' => 'new-password'],
                    'constraints' => [
                        new NotBlank(),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Your password should be at least {{ limit }} characters',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                ],
                'second_options'=>[
                    'attr' => ['autocomplete' => 'new-password','onclick'=>'this.select()'],
                    'label_html' => true,
                    'label'=>$this->translator->trans('confirm.password.label').'  * <span class="dec-icon"><i class="fal fa-key"></i></span>',
                    'constraints' => [
                        new NotBlank(),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Your password should be at least {{ limit }} characters',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'invalid_message' => $this->translator->trans('not.match.password.label')
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
