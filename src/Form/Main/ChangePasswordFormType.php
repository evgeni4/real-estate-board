<?php

namespace App\Form\Main;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class ChangePasswordFormType extends AbstractType
{
    public function __construct(public TranslatorInterface $translator)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', RepeatedType::class, [
                'required'=>false,
                'mapped'=>false,
                'type' => PasswordType::class,
                'first_options' => [
                    'label_html' => true,
                    'label'=>$this->translator->trans('new.password.label').'  * <span class="dec-icon"><i class="fal fa-key"></i></span>',
                    'attr' => ['autocomplete' => 'new-password'],
                    'constraints' => [
                        new NotBlank([
                            'message' => $this->translator->trans('enter.password.label'),
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => $this->translator->trans('password.length.label').' {{ limit }} '.$this->translator->trans('characters.label'),
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                ],
                'second_options' => [
                    'label_html' => true,
                    'label'=>$this->translator->trans('confirm.password.label').'  * <span class="dec-icon"><i class="fal fa-key"></i></span>',
                    'attr' => ['autocomplete' => 'new-password'],
                    'constraints' => [
                        new NotBlank([
                            'message' => $this->translator->trans('enter.password.label'),
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => $this->translator->trans('password.length.label').' {{ limit }} '.$this->translator->trans('characters.label'),
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                ],
                'invalid_message' => $this->translator->trans('not.match.password.label'),
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                //'mapped' => false,
            ])
            ->add('current_password',PasswordType::class,[
                'label_html' => true,
                'label'=>$this->translator->trans('current.password.label').'  * <span class="dec-icon"><i class="fal fa-key"></i></span>',
                'required'=>false,
                'mapped'=>false,
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('enter.password.label'),
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
