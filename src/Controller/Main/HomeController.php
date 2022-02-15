<?php

namespace App\Controller\Main;

use App\Service\Admin\Settings\SettingsServiceInterface;
use App\Service\Property\PropertyServiceInterface;
use App\Service\Seo\SeoServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        public SeoServiceInterface      $seoService,
        public SettingsServiceInterface $settingsService,
        public PropertyServiceInterface $propertyService

    )
    {
    }

    #[Route('/', name: 'app_home')]
    public function home(Request $request): Response
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
        $properties = $this->propertyService->findAllProperties();
        return $this->render('main/home/index.html.twig',
            [
                'properties' => $properties
            ]
        );
    }

    public function templateTopBar(): Response
    {
        $settings = $this->settingsService->findOneRecord();
        return $this->render('main/_embed/_main_header/_top_bar.html.twig',
            [
                'settings' => $settings,
            ]);
    }
}
