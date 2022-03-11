<?php

namespace App\Controller\Main\Dashboard;

use App\Entity\PricingPlan;
use App\Entity\UserPricingPlan;
use App\Form\Main\Handler\PricingPlanFormHandler;
use App\Service\Admin\PricingPlan\PricingPlanServiceInterface;
use App\Service\Admin\Settings\SettingsServiceInterface;
use App\Service\Seo\SeoServiceInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Stripe\Exception\ApiErrorException;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/dashboard/pricing')]
class PricingPlanController extends AbstractController
{
    public function __construct(
        private PricingPlanServiceInterface $pricingPlanService,
        public SeoServiceInterface          $seoService,
        public TranslatorInterface          $translator,
        public SettingsServiceInterface     $settingsService,
        private Breadcrumbs                 $breadcrumbs,
        private PricingPlanFormHandler      $pricingPlanFormHandler
    )
    {
    }

    #[Route('/', name: 'main_show_pricing')]
    public function show(Request $request): Response
    {
        $locale = $request->getLocale();
        $settings = $this->settingsService->findOneRecord();
        $this->breadcrumbs->addItem($this->translator->trans('pricings.label'));
        $this->seoService->seo(
            $settings->translate($locale)->getSiteName() . '|' . $this->translator->trans('pricings.label'),
            $settings->translate($locale)->getMetaKeywords(),
            $settings->translate($locale)->getMetaDescription(),
            $this->translator->trans('pricings.label'),
            $settings->translate($locale)->getMetaDescription(),
            $settings->translate($locale)->getSiteName(),
        );
        $plans = $this->pricingPlanService->findActivePlans();
        return $this->render('main/dashboard/pricing/show.html.twig',
            [
                'plans' => $plans
            ]);
    }

    /**
     * @throws ApiErrorException
     */
    #[Route('/{uuid}', name: 'main_plan_pricing_buy')]
    public function buyPlan(PricingPlan $plan, Request $request): Response
    {
        $settings = $this->settingsService->findOneRecord();
        $locale = $request->getLocale();
        $token = $request->request->get('stripeToken');
        $this->breadcrumbs->addItem($this->translator->trans('pricing.label'));
        $this->breadcrumbs->addItem($plan->translate($locale)->getTitle());
        $this->seoService->seo(
            $settings->translate($locale)->getSiteName() . '|' . $this->translator->trans('pricings.label') . '|' . $plan->translate($locale)->getTitle(),
            $settings->translate($locale)->getMetaKeywords(),
            $settings->translate($locale)->getMetaDescription(),
            $this->translator->trans('pricings.label'),
            $settings->translate($locale)->getMetaDescription(),
            $settings->translate($locale)->getSiteName(),
        );

        if ($request->isMethod('post')) {
            if ($plan->getPrice() > 0) {
                \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));
                \Stripe\Charge::create(array(
                    "amount" => $plan->getPrice() * 100,
                    "currency" => "eur",
                    "source" => $token,
                    "description" => $plan->translate($locale)->getTitle()
                ));
            }
            $plan = $this->pricingPlanFormHandler->processUserPricingPlan($plan);
            $this->addFlash('info', $plan->translate($locale)->getTitle() . ' ' . $this->translator->trans('pricing_plans.update.label'));
            return $this->redirectToRoute('main_dashboard');
        }
        return $this->render('main/dashboard/pricing/paypage.html.twig', [
                'plan' => $plan,
                'stripe_public_key' => $this->getParameter('stripe_public_key')
            ]
        );
    }
}