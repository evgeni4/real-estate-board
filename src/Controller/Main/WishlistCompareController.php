<?php

namespace App\Controller\Main;

use App\Entity\Property;
use App\Service\Admin\Settings\SettingsServiceInterface;
use App\Service\Property\PropertyServiceInterface;
use App\Service\Seo\SeoServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/listing')]
class WishlistCompareController extends AbstractController
{
    public function __construct(
        private PropertyServiceInterface $propertyService,
        private SessionInterface         $session,
        private TranslatorInterface      $translator,
        private SeoServiceInterface      $seoService,
        public SettingsServiceInterface $settingsService,
    )
    {
    }
 #[Route('/listing/compare', name: 'main_compare')]
     public function compare(Request $request): Response
     {
         $settings = $this->settingsService->findOneRecord();
         $this->seoService->seo(
             $settings->translate($request->getLocale())->getSiteName(),
             $settings->translate($request->getLocale())->getMetaKeywords(),
             $settings->translate($request->getLocale())->getMetaDescription(),
             $settings->translate($request->getLocale())->getSiteName(),
             $settings->translate($request->getLocale())->getMetaKeywords(),
             $settings->translate($request->getLocale())->getMetaDescription()
         );
         $compares = [];
         if ($this->session->get('compare')) {
             $compares = $this->propertyService->wishlistProperties($this->session->get('compare'));
         }
         return $this->render('main/listing/compare/compare.html.twig',
             [
                 'compares' => $compares
             ]);
     }
    #[Route('/add/wishlist/{uuid}', name: 'main_listing_wishlist')]
    public function addWishlistAction(Property $property): RedirectResponse
    {
        if (!$property) {
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        $wishlist = $this->session->get('wishlist', []);
        if (empty($wishlist[$property->getId()])) {
            $wishlist[$property->getId()] = $property->getId();
            $this->session->set('wishlist', $wishlist);
            $this->addFlash('success', $this->translator->trans('wishlist.added.successfully.label'));
            return $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->addFlash('warning', $this->translator->trans('wishlist.added.already.label'));
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }

    #[Route('/delete/wishlist/{uuid}', name: 'main_listing_wishlist_delete')]
    public function deleteActionWishlist(Property $property)
    {
        if (!$property) {
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        $wishlist = $this->session->get('wishlist');
        if (!empty($wishlist[$property->getId()])) {
            unset($wishlist[$property->getId()]);
            $this->session->set('wishlist', $wishlist);
            $this->addFlash('success', $this->translator->trans('delete.successfully.label'));
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    #[Route('/delete/wishlist', name: 'main_listing_wishlist_delete_all')]
    public function deleteAllActionWishlist()
    {
        if (!$this->session->get('wishlist')) {
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        $wishlist = $this->session->get('wishlist');
        if (!empty($wishlist)) {
            unset($wishlist);
            $this->session->set('wishlist', []);
            $this->addFlash('success', $this->translator->trans('delete.successfully.label'));
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    #[Route('/add/compare/{uuid}', name: 'main_listing_compare')]
    public function addCompareAction(Property $property): RedirectResponse
    {
        if (!$property) {
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        $compare = $this->session->get('compare', []);
        if (empty($compare[$property->getId()])) {
            $compare[$property->getId()] = $property->getId();
            $this->session->set('compare', $compare);
            $this->addFlash('success', $this->translator->trans('compare.added.successfully.label'));
            return $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->addFlash('warning', $this->translator->trans('compare.added.already.label'));
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }

    #[Route('/delete/compare/{uuid}', name: 'main_listing_compare_delete')]
    public function deleteCompareAction(Property $property)
    {
        if (!$property) {
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        $compare = $this->session->get('compare');
        if (!empty($compare[$property->getId()])) {
            unset($compare[$property->getId()]);
            $this->session->set('compare', $compare);
            $this->addFlash('success', $this->translator->trans('delete.successfully.compare.label'));
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function wishlistCompare(): Response
    {
        $wishlists = [];
        $compares = [];
        if ($this->session->get('wishlist')) {
            $wishlists = $this->propertyService->wishlistProperties($this->session->get('wishlist'));
        }
        if ($this->session->get('compare')) {
            $compares = $this->propertyService->wishlistProperties($this->session->get('compare'));
        }
        return $this->render('main/listing/_embed/wishlist_compare/_wishlist_compare.html.twig',
            [
                'wishlists' => $wishlists,
                'compares' => $compares
            ]);
    }
}