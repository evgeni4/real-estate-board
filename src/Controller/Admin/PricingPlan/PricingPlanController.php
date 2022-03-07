<?php

namespace App\Controller\Admin\PricingPlan;

use App\Entity\PricingPlan;
use App\Form\Main\PricingPlan\PricingPlanFormType;
use App\Service\Admin\Category\CategoryServiceInterface;
use App\Service\Admin\PricingPlan\PricingPlanServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/admin/pricing')]
class PricingPlanController extends AbstractController
{
    public function __construct(
        private TranslatorInterface      $translator,
        private Breadcrumbs              $breadcrumbs,
        private PricingPlanServiceInterface $planService,
    )
    {
    }
    #[Route('/show', name: 'admin_pricing_plans_show')]
    public function show(): Response
    {
        $this->breadcrumbs->addItem($this->translator->trans('pricings.label'));
        return $this->render('admin/pages/pricing/show.html.twig', [
            'pricingPlans' => $this->planService->findAll(),
        ]);
    }
    #[Route('/new', name: 'admin_pricing_plans_new')]
    public function new(Request $request): Response
    {
        $a = null;
        $b = 0;
        if (null===$b){
            dd('ok');
        }
        $this->breadcrumbs->addRouteItem($this->translator->trans('pricings.label'), 'admin_pricing_plans_show');
        $this->breadcrumbs->addItem($this->translator->trans('add.label'));
        $pricingPlan = new PricingPlan();
        $form = $this->createForm(PricingPlanFormType::class, $pricingPlan);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->planService->add($pricingPlan);
            $this->addFlash('success', $this->translator->trans('pricing_plans.added.label'));
            return $this->redirectToRoute('admin_pricing_plans_show');
        }
        return $this->renderForm('admin/pages/pricing/new.html.twig',
            [
                'form' => $form
            ]
        );
    }
    #[Route('/{id}', name: 'admin_pricing_plans_edit')]
    public function edit(PricingPlan $pricingPlan,Request $request): Response
    {
        $this->breadcrumbs->addRouteItem($this->translator->trans('pricing.label'), 'admin_pricing_plans_show');
        $this->breadcrumbs->addItem($this->translator->trans('edit.label'));
        $form = $this->createForm(PricingPlanFormType::class, $pricingPlan);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->planService->add($pricingPlan);
            $this->addFlash('success', $this->translator->trans('pricing_plans.update.label'));
            return $this->redirectToRoute('admin_pricing_plans_show');
        }
        return $this->renderForm('admin/pages/pricing/new.html.twig',
            [
                'form' => $form
            ]
        );
    }
    #[Route('/delete/{id}', name: 'admin_category_delete')]
    public function delete(Request $request, PricingPlan $pricingPlan): Response
    {
        $this->planService->delete($pricingPlan);
        $this->addFlash('success', $this->translator->trans('pricing_plans.delete.label'));
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}