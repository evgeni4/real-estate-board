<?php

namespace App\Controller\Main;

use App\Entity\Category;
use App\Entity\Property;
use App\Entity\Reviews;
use App\Entity\Type;
use App\Form\Main\Handler\PropertyFormHandler;
use App\Form\Main\Search\SearchAdvancedType;
use App\Form\Main\User\ReviewsUserFormType;
use App\Service\Admin\Settings\SettingsServiceInterface;
use App\Service\Currency\CurrencyServiceInterface;
use App\Service\Property\PropertyServiceInterface;
use App\Service\Reviews\ReviewsServiceInterface;
use App\Service\Seo\SeoServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
        private CurrencyServiceInterface $currencyService,
        private SessionInterface         $session,
        private PaginatorInterface $paginator,
        private SettingsServiceInterface $settingsService

    )
    {
    }

    #[Route('/filter', name: 'main_listing_all')]
    public function allProperty(Request $request): Response
    {
        $settings = $this->settingsService->findOneRecord();
        $properties = [];
        if ($request->get('search_home')) {
            $properties = $this->propertyService->findSearchResultProperties($request->get('search_home'));
        }
        if ($request->get('search')) {
            $properties = $this->propertyService->findSearchResultProperties($request->get('search'));
        }
        if ($request->get('search_advanced')) {
            $properties = $this->propertyService->findSearchResultProperties($request->get('search_advanced'));
        }

        $this->seoService->seoProperty($properties ? $properties[0] : null, $request->getLocale());
        $query= $this->paginator->paginate($properties, $request->query->getInt('page', 1), $settings->getAdsPerPage());
        return $this->render('main/listing/all/show.html.twig',
            [
                'properties' => $query,
            ]);
    }

    #[Route('/type/{uuid}', name: 'main_listing_by_type')]
    public function byType(Type $type, Request $request): Response
    {
        $this->settingsService->closeSite();
        $settings = $this->settingsService->findOneRecord();
        $this->seoService->seoProperty($type, $request->getLocale());
        $query   = $this->propertyService->findByTypesProperties($type);
        $properties= $this->paginator->paginate($query, $request->query->getInt('page', 1), $settings->getAdsPerPage());
        return $this->render('main/listing/all/show.html.twig',
            [
                'properties' => $properties,
            ]);
    }

    #[Route('/category/{uuid}', name: 'main_listing_by_category')]
    public function byCategory(Category $category, Request $request): Response
    {

        $settings = $this->settingsService->findOneRecord();
        $this->seoService->seoProperty($category, $request->getLocale());
        $query = $this->propertyService->findByCategoryProperties($category);
        $properties= $this->paginator->paginate($query, $request->query->getInt('page', 1), $settings->getAdsPerPage());
        return $this->render('main/listing/all/show.html.twig',
            [
                'properties' => $properties,
            ]);
    }

    #[Route('/single/{uuid}', name: 'main_listing_single')]
    public function single(Property $property, Request $request): Response
    {
        if (null == $property->getDuration()) {
            return $this->redirectToRoute('app_home');
        }
        $this->propertyService->viewed($request->getClientIp(), $property);
        $this->seoService->seoProperty($property, $request->getLocale());
        $this->breadcrumbs->addRouteItem("Home", 'app_home');
        $this->breadcrumbs->addRouteItem($property->getCategory(), 'app_home');
        $this->breadcrumbs->addRouteItem($property->getTypes(), 'app_home');

        $reviewsFromProperty = $this->reviewsService->getReviewsFromProperty($property);
        $properties = $this->propertyService->featuredProperty($property);
//        dd($this->reviewsService->getReviewsFromProperty($property));
//        dd($this->propertyService->featuredProperty($property));
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
                'reviewsFromProperty' => $reviewsFromProperty,
                'property' => $property,
                'form' => $form->createView()
            ]);
    }

    public function featured($property): Response
    {
        $properties = $this->propertyService->featuredProperty($property);
        return $this->render('main/listing/_embed/_listing.featured.html.twig',
            [
                'properties' => $properties
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

    public function reviewsFromProperty(Property $property): Response
    {
        $reviewsFromProperty = $this->reviewsService->getReviewsFromProperty($property);
        return $this->render('main/listing/_embed/_reviews_property.item.html.twig', ['reviewsFromProperty' => $reviewsFromProperty,]);
    }

    public function convert(float $price, string $code): Response
    {
        $price = $this->currencyService->convertor($price, $code);
        return $this->render('main/listing/_embed/_convert.item.html.twig', ['price' => $price, 'code' => $code]);
    }
    public function convertPricing(float $price, string $code): Response
    {
        $price = $this->currencyService->convertor($price, $code);
        return $this->render('main/listing/_embed/_convert.pricing.html.twig', ['price' => $price, 'code' => $code]);
    }
}