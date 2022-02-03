<?php

namespace App\Controller\Main\Dashboard;

use App\Entity\Amenities;
use App\Entity\Property;
use App\Entity\PropertyAmenities;
use App\Form\Main\Handler\PropertyFormHandler;
use App\Form\Main\Property\PropertyFormType;
use App\Repository\PropertyAmenitiesRepository;
use App\Service\Property\PropertyServiceInterface;
use App\Service\Seo\SeoServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/dashboard')]
class ListingController extends AbstractController
{
    public function __construct(
        private Breadcrumbs         $breadcrumbs,
        private TranslatorInterface $translator,
        private SeoServiceInterface $seoService,
        private PropertyFormHandler $propertyFormHandler
    )
    {
    }

    #[Route('/add', name: 'main_add_listing')]
    public function add(Request $request): Response
    {
        //dd(abs( crc32( uniqid() ) ));
        $this->breadcrumbs->addItem($this->translator->trans('add.listing.label'));
        $property = new Property();
        $form = $this->createForm(PropertyFormType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $property = $this->propertyFormHandler->processAddPropertyForm($property, $form, $request);
            $this->addFlash('success', 'ok added');
            return $this->redirectToRoute('main_add_listing');
        }
        return $this->render('main/dashboard/listing/new.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    #[Route('/edit/{id}', name: 'main_edit_listing')]
    public function edit(Request $request, Property $property, PropertyAmenitiesRepository $propertyAmenitiesRepository): Response
    {
        $amenity = $property->getPropertyAmenities()->getValues()[0]->getAmenity();
        $test = $propertyAmenitiesRepository->findOneBy(['property' => $property]);
        $form = $this->createForm(PropertyFormType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$amenities = $form->get('amenity')->getData();
            $amenities = $request->request->get('property_form')['amenity'] ?: null;
            // dd($form->get('amenities')->getData());
            // dd($request->request->all());
            $demo = $test->setAmenity($amenities);
            $property->addPropertyAmenity($demo);
            $this->propertyService->edit($property);
            dd($property);
        }
        return $this->render('main/dashboard/listing/edit.html.twig',
            [
                'form' => $form->createView(),
                'amenity' => $amenity
            ]);
    }
}