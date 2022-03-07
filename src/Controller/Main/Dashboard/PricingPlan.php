<?php

namespace App\Controller\Main\Dashboard;

use App\Service\Admin\PricingPlan\PricingPlanServiceInterface;
use App\Service\Admin\Settings\SettingsServiceInterface;
use App\Service\Seo\SeoServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/dashboard/pricing')]
class PricingPlan extends AbstractController
{
    public function __construct(
        private PricingPlanServiceInterface $pricingPlanService,
        public SeoServiceInterface  $seoService,
        public TranslatorInterface  $translator,
        public SettingsServiceInterface $settingsService,
    )
    {
    }

    #[Route('/', name: 'main_show_pricing')]
    public function show(Request $request): Response
    {
        $locale = $request->getLocale();
        $settings = $this->settingsService->findOneRecord();
        $this->seoService->seo(
            $settings->translate($locale)->getSiteName().'|'.$this->translator->trans('pricings.label'),
            $settings->translate($locale)->getMetaKeywords(),
            $settings->translate($locale)->getMetaDescription(),
            $this->translator->trans('pricings.label'),
            $settings->translate($locale)->getMetaDescription(),
            $settings->translate($locale)->getSiteName(),
        );
        $plans = $this->pricingPlanService->findAll();
        return $this->render('main/dashboard/pricing/show.html.twig',
        [
            'plans'=>$plans
        ]);
    }
}