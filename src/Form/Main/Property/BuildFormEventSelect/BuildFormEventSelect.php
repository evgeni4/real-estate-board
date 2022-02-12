<?php

namespace App\Form\Main\Property\BuildFormEventSelect;

use App\Entity\City;
use App\Entity\PriceType;
use App\Entity\State;
use App\Repository\CityRepository;
use App\Repository\PriceTypeRepository;
use App\Repository\StateRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class BuildFormEventSelect
{
    public function __construct(public TranslatorInterface $translator)
    {
    }

    public function builderSelect($builder)
    {
        $addStateForm = function (FormInterface $form, $country_id) {
            $form->add('state', EntityType::class, [
                'label' => $this->translator->trans('state.label'),
                'placeholder' => $this->translator->trans('select.state.label'),
                'required' => false,
                'attr' => [
                    'class' => 'c-form'
                ],
                'class' => State::class,
                'query_builder' => function (StateRepository $repository) use ($country_id) {
                    return $repository->createQueryBuilder('s')
                        ->where('s.country = :id')
                        ->setParameter('id', $country_id)
                        ->orderBy('s.name', 'ASC');
                   // echo "<pre>"; print_r(($sql->getQuery()->getArrayResult())); exit;
                },
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('select.state.label'),
                    ]),
                ],
            ]);
        };
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($addStateForm) {
                $country = $event->getData()->getCountry();
                $country_id = $country ? $country->getId() : null;
                $addStateForm($event->getForm(), $country_id);
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($addStateForm) {
                $data = $event->getData();
                $country_id = array_key_exists('country', $data) ? $data['country'] : null;
                $addStateForm($event->getForm(), $country_id);
            }
        );
        //**************** End State Form
        //**************** Start City Form
        $addCityForm = function (FormInterface $form, $state_id) {

            $form->add('city', EntityType::class, [
                'label' => $this->translator->trans('city.label'),
                'placeholder' => $this->translator->trans('select.city.label'),
                'required' => false,
                'attr' => [
                    'class' => 'c-form'
                ],
                'class' => City::class,
                'query_builder' => function (CityRepository $repository) use ($state_id) {
                    return $repository->createQueryBuilder('c')
                        ->where('c.state = :id')
                        ->setParameter('id', $state_id)
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('select.city.label'),
                    ]),
                ],
            ]);
        };
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($addCityForm) {
                $state = $event->getData()->getState();
                $state_id = $state ? $state->getId() : null;

                $addCityForm($event->getForm(), $state_id);
            }
        );
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($addCityForm) {
                $data = $event->getData();
                $state_id = array_key_exists('state', $data) ? $data['state'] : null;
                $addCityForm($event->getForm(), $state_id);
            }
        );
        //**************** End City Form


        $addPeriodForm = function (FormInterface $form, $type_id) {
            $form->add('period', EntityType::class, [
                'label' => $this->translator->trans('period.label'),
                'placeholder' => $this->translator->trans('select.period.label'),
                'required' => false,
                'attr' => [
                    'class' => 'c-form'
                ],
                'class' => PriceType::class,
                'query_builder' => function (PriceTypeRepository $repository) use ($type_id) {
                    return $repository->createQueryBuilder('pt')
                        ->where('pt.type = :id')
                        ->setParameter('id', $type_id) ;
                },
            ]);
        };
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($addPeriodForm) {
                $type = $event->getData()->getTypes();
                $type_id = $type ? $type->getId() : null;
                $addPeriodForm($event->getForm(), $type_id);
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($addPeriodForm) {
                $data = $event->getData();
                $type_id = array_key_exists('types', $data) ? $data['types'] : null;
                $addPeriodForm($event->getForm(), $type_id);
            }
        );

//         $builder->get('types')->addEventListener(
//             FormEvents::POST_SUBMIT,
//             function (FormEvent $event) {
//                 $form = $event->getForm();
//                 $form->getParent()->add('period',EntityType::class,[
//                     'class'=>PriceType::class,
//                     'placeholder'=>'select',
//                     'attr' => [
//                         'class' => 'c-form'
//                     ],
//                     'choices'=>$form->getData()->getPriceTypes()
//                 ]);
//           });
//         $builder->addEventListener(
//             FormEvents::PRE_SET_DATA,
//             function (FormEvent $event){
//                 $form =$event->getForm();
//                 $data = $event->getData();
//                 $period = $data->getPeriod();
//                 if ($period){
//                     $form->add('period',EntityType::class,[
//                         'class'=>PriceType::class,
//                         'placeholder'=>'select',
//                         'attr' => [
//                             'class' => 'c-form'
//                         ],
//                         'choices'=>$period->getType()->getPriceTypes()
//                     ]);
//                 }else{
//                     $form->add('period',EntityType::class,[
//                         'class'=>PriceType::class,
//                         'placeholder'=>'select',
//                         'attr' => [
//                             'class' => 'c-form'
//                         ],
//                         'choices'=>[]
//                     ]);
//                 }
//             }
//         );
    }
}