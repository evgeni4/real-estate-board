<?php

namespace App\Controller\Main\Dashboard;

use App\Entity\Amenities;
use App\Entity\Property;
use App\Entity\PropertyAmenities;
use App\Entity\PropertyImage;
use App\Entity\PropertyPlan;
use App\Entity\PropertyRoomsWidget;
use App\Form\Main\Handler\PropertyFormHandler;
use App\Form\Main\Property\PropertyFormType;
use App\Repository\PropertyAmenitiesRepository;
use App\Service\Admin\Settings\SettingsServiceInterface;
use App\Service\Manager\PropertyManager\PropertyManager;
use App\Service\Manager\PropertyManager\PropertyManagerHelper;
use App\Service\Property\PropertyServiceInterface;
use App\Service\Reviews\ReviewsServiceInterface;
use App\Service\Seo\SeoServiceInterface;
use App\Service\User\UserServiceInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/dashboard/listing')]
class ListingController extends AbstractController
{
    public function __construct(
        private Breadcrumbs              $breadcrumbs,
        private TranslatorInterface      $translator,
        private SeoServiceInterface      $seoService,
        private PropertyFormHandler      $propertyFormHandler,
        private PropertyServiceInterface $propertyService,
        public SettingsServiceInterface  $settingsService,
        public UserServiceInterface      $userService,
    )
    {
    }

    #[Route('/show', name: 'main_show_listing')]
    public function show(Request $request): Response
    {
        $locale = $request->getLocale();
        $settings = $this->settingsService->findOneRecord();
        $this->seoService->seo(
            $settings->translate($locale)->getSiteName() . '|' . $this->translator->trans('all.properties.label'),
            $settings->translate($locale)->getMetaKeywords(),
            $settings->translate($locale)->getMetaDescription(),
            $this->translator->trans('all.properties.label'),
            $settings->translate($locale)->getMetaDescription(),
            $settings->translate($locale)->getSiteName(),
        );
        $this->breadcrumbs->addItem($this->translator->trans('all.properties.label'));
        $properties = $this->propertyService->findAllByAgentListing();

        return $this->render('main/dashboard/listing/show.html.twig',
            [
                'properties' => $properties,

            ]);
    }


    public function template(): Response
    {
        $properties = $this->propertyService->findAllByAgentListing();
        return $this->render('main/dashboard/listing/show/_show.html.twig',
            [
                'properties' => $properties
            ]);
    }

    #[Route('/add', name: 'main_add_listing')]
    public function add(Request $request): Response
    {
        $user = $this->userService->currentUser();
        $tariffPlan = $this->userService->pricingPlanByUser();
        if ($tariffPlan == null) {
            return $this->redirectToRoute('main_show_pricing');
        }
        if (count($user->getProperties()) > $tariffPlan->getPricingPlan()->getListingCount()){
            $this->addFlash('info', $this->translator->trans('max.count.properties') . ' ' . $tariffPlan->getPricingPlan()->getCountImage());

            return $this->redirectToRoute('main_show_pricing');
        }
            //dd(abs( crc32( uniqid() ) ));
            $locale = $request->getLocale();
        $settings = $this->settingsService->findOneRecord();
        $this->seoService->seo(
            $settings->translate($locale)->getSiteName() . '|' . $this->translator->trans('add.listing.label'),
            $settings->translate($locale)->getMetaKeywords(),
            $settings->translate($locale)->getMetaDescription(),
            $this->translator->trans('add.listing.label'),
            $settings->translate($locale)->getMetaDescription(),
            $settings->translate($locale)->getSiteName(),
        );
        $this->breadcrumbs->addItem($this->translator->trans('add.listing.label'));
        $property = new Property();
        $form = $this->createForm(PropertyFormType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (count($form->get('images')->getData()) > $tariffPlan->getPricingPlan()->getCountImage()) {
                $this->addFlash('info', $this->translator->trans('max.count.image') . ' ' . $tariffPlan->getPricingPlan()->getCountImage());
                return $this->redirectToRoute('main_add_listing');
            }
            $property = $this->propertyFormHandler->processAddPropertyForm($property, $form, $request, $tariffPlan);
            $this->addFlash('success', $this->translator->trans('add.listing.message.label'));
            return $this->redirectToRoute('main_add_listing');
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('info', $this->translator->trans('check.form.label'));
        }
        return $this->render('main/dashboard/listing/new.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    #[Route('/edit/{uuid}', name: 'main_edit_listing')]
    public function edit(Request $request, Property $property): Response
    {
        $tariffPlan = $this->userService->pricingPlanByUser();
        if ($tariffPlan == null) {
            return $this->redirectToRoute('main_show_pricing');
        }
        $settings = $this->settingsService->findOneRecord();
        $this->seoService->seoProperty($property, $request->getLocale());
        $form = $this->createForm(PropertyFormType::class, $property);
        $form->handleRequest($request);
        $propertyArrayAmenity = $this->propertyService->amenityFromProperty($property);

        if ($form->isSubmitted() && $form->isValid()) {
            $property = $this->propertyFormHandler->processUpdatePropertyForm($property, $form, $request);
            $this->addFlash('success', $this->translator->trans('update.listing.message.label'));
            return $this->redirectToRoute('main_edit_listing', ['uuid' => $property->getUuid()]);
        }
        return $this->render('main/dashboard/listing/edit.html.twig',
            [
                'form' => $form->createView(),
                'property' => $property,
                'propertyArrayAmenity' => $propertyArrayAmenity,
            ]);
    }

    #[Route('/disable/{uuid}', name: 'main_disable_listing')]
    public function disable(Property $property, Request $request): Response
    {
        if ($property) {
            $property = $property->getPublished() ? $property->setPublished(false) : $property->setPublished(true);
            $this->propertyService->edit($property);
            $this->addFlash('success', $this->translator->trans('property.disable.label'));
            return $this->redirectToRoute('main_show_listing');
        }
        return $this->render('main/dashboard/listing/show.html.twig');
    }

    #[Route('/image-delete/{id}', name: 'main_image_listing_delete')]
    public function deleteImage(PropertyImage $propertyImage, PropertyManagerHelper $propertyManagerHelper): Response
    {
        $property = $propertyImage->getProperty();
        $propertyImageDir = $propertyManagerHelper->getPropertyImageDir($propertyImage->getSlug());
        $propertyManagerHelper->removeImageFromProperty($propertyImage, $propertyImageDir);
        $this->addFlash('success', $this->translator->trans('image.listing.delete.label'));
        return $this->redirectToRoute('main_edit_listing', ['uuid' => $property->getUuid()]);
    }

    #[Route('/amenity/{ids}/{id}', name: 'main_amenity_show_hide')]
    public function amenity($ids, Property $property, Request $request, PropertyManagerHelper $propertyManagerHelper, EntityManagerInterface $entityManager): Response
    {

        if ($request->isXmlHttpRequest()) {
            $propertyManagerHelper->updateCheckedPropertyAmenity($ids, $property);
            $entityManager->flush();
        }
        return new JsonResponse(['message' => 'ok', 200]);
    }

    #[Route('/delete-widget/{id}', name: 'main_delete_widget')]
    public function deleteWidget(PropertyRoomsWidget $propertyRoomsWidget, PropertyManagerHelper $propertyManagerHelper): Response
    {
        $property = $propertyRoomsWidget->getProperty();
        $propertyWidgetImageDir = $propertyManagerHelper->getPropertyWidgetImageDir($propertyRoomsWidget->getSlug());
        $propertyManagerHelper->removeImageFromPropertyWidget($propertyRoomsWidget, $propertyWidgetImageDir);
        $this->addFlash('success', $this->translator->trans('image.listing.delete.label'));
        return $this->redirectToRoute('main_edit_listing', ['uuid' => $property->getUuid()]);
    }

    #[Route('/delete-plan/{id}', name: 'main_delete_plan')]
    public function plan(PropertyPlan $propertyPlan, PropertyManagerHelper $propertyManagerHelper): Response
    {
        $property = $propertyPlan->getPropertyPlan();
        $propertyPlanImageDir = $propertyManagerHelper->getPropertyPlanImageDir($propertyPlan->getSlug());
        $propertyManagerHelper->removePropertyPlan($propertyPlan, $property, $propertyPlanImageDir);
        $this->addFlash('success', $this->translator->trans('image.listing.delete.label'));
        return $this->redirectToRoute('main_edit_listing', ['uuid' => $property->getUuid()]);
    }

    #[Route('/widget-amenity/{widget}/{id}/{property}', name: 'main_widget_amenity_show_hide')]
    public function widgetAmenity(PropertyRoomsWidget $widget, $id, Property $property, Request $request, PropertyManagerHelper $propertyManagerHelper, EntityManagerInterface $entityManager): Response
    {
        if ($request->isXmlHttpRequest()) {
            $propertyManagerHelper->updateCheckedPropertyWidgetAmenity($widget, $id, $property);
            $entityManager->flush();
        }
        return new JsonResponse(['message' => 'ok', 200]);
    }
}