<?php

namespace App\Controller\Main;

use App\Entity\Property;
use App\Entity\Reviews;
use App\Form\Main\Handler\PropertyFormHandler;
use App\Form\Main\User\ReviewsUserFormType;
use App\Service\Admin\Settings\SettingsServiceInterface;
use App\Service\Currency\CurrencyServiceInterface;
use App\Service\Property\PropertyServiceInterface;
use App\Service\Reviews\ReviewsServiceInterface;
use App\Service\Seo\SeoServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/listings')]
class ListingController extends AbstractController
{
    public function __construct(
        private Breadcrumbs              $breadcrumbs,
        private SeoServiceInterface      $seoService,
        private PropertyServiceInterface $propertyService,
        private ReviewsServiceInterface  $reviewsService,
        private CurrencyServiceInterface $currencyService

    )
    {
    }

    #[Route('/all', name: 'main_listing_all')]
    public function index(): Response
    {
        return $this->render('main/listing/all/show.html.twig',
            [
            ]);
    }

    #[Route('/single/{uuid}', name: 'main_listing_single')]
    public function single(Property $property, Request $request): Response
    {
        $this->seoService->seoProperty($property, $request->getLocale());
        $this->breadcrumbs->addRouteItem("Home", 'app_home');
        $this->breadcrumbs->addRouteItem($property->getCategory(), 'app_home');
        $this->breadcrumbs->addRouteItem($property->getTypes(), 'app_home');
        $reviewsFromAgent = $this->reviewsService->getReviewsFromUser($property->getAgent());
        $review = new Reviews();
        $form = $this->createForm(ReviewsUserFormType::class, $review);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $review->setProperty($property);
            $this->reviewsService->add($review, $property->getAgent());
            return $this->redirectToRoute('main_listing_single', ['uuid' => $property->getUuid()]);
        }
        return $this->render('main/listing/single/show.html.twig',
            [
                'reviewsFromAgent' => $reviewsFromAgent,
                'property' => $property,
                'form' => $form->createView()
            ]);
    }

    public function renderListingItem($property): Response
    {
        $properties = $this->propertyService->similarProperties($property);
        return $this->render('main/listing/_embed/_listing.item.html.twig',
            [
                'properties' => $properties
            ]);
    }

    public function convert(float $price, string $code): Response
    {
        $price = $this->currencyService->convertor($price, $code);
        return $this->render('main/listing/_embed/_convert.item.html.twig', ['price' => $price, 'code' => $code]);
    }
}