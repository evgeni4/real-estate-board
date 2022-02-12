<?php

namespace App\Controller\Admin\Type;

use App\Entity\PriceType;
use App\Entity\Type;
use App\Form\Admin\Type\TypeFormType;
use App\Form\Main\Property\PriceTypeFormType;
use App\Service\Admin\Type\TypeServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/admin/type')]
class TypeController extends AbstractController
{
    public function __construct(
        private TranslatorInterface  $translator,
        private Breadcrumbs          $breadcrumbs,
        private TypeServiceInterface $typeService,
    )
    {
    }

    #[Route('/show', name: 'admin_type_show')]
    public function show(Request $request): Response
    {
        $this->breadcrumbs->addItem($this->translator->trans('catalog.label'));
        $this->breadcrumbs->addItem($this->translator->trans('type.label'));
        return $this->render('admin/pages/type/show.html.twig', [
            'types' => $this->typeService->all(),
        ]);
    }

    #[Route('/new', name: 'admin_type_new')]
    public function new(Request $request): Response
    {
        $this->breadcrumbs->addItem($this->translator->trans('catalog.label'));
        $this->breadcrumbs->addItem($this->translator->trans('type.label'));
        $this->breadcrumbs->addItem($this->translator->trans('add.label'));
        $type = new Type();
        $form = $this->createForm(TypeFormType::class, $type);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->typeService->add($type);
            $this->addFlash('success', $this->translator->trans('type.added.label'));
            return $this->redirectToRoute('admin_type_show');
        }
        return $this->renderForm('admin/pages/type/new.html.twig', ['form' => $form]);
    }

    #[Route('/edit/{uuid}', name: 'admin_type_edit')]
    public function edit(Request $request, Type $type): Response
    {
        $this->breadcrumbs->addItem($this->translator->trans('catalog.label'));
        $this->breadcrumbs->addItem($this->translator->trans('type.label'));
        $this->breadcrumbs->addItem($this->translator->trans('edit.label'));
        $form = $this->createForm(TypeFormType::class, $type);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->typeService->edit($type);
            $this->addFlash('success', $this->translator->trans('type.edit.label'));
            return $this->redirectToRoute('admin_type_show');
        }
        return $this->renderForm('admin/pages/type/new.html.twig', ['form' => $form]);
    }

    #[Route('/delete/{id}', name: 'admin_type_delete')]
    public function delete(Request $request, Type $type): Response
    {
        if ($type) {
            $this->typeService->delete($type);
            $this->addFlash('success', $this->translator->trans('type.delete.label'));
            return $this->redirectToRoute('admin_type_show');
        }
        return $this->redirectToRoute('admin_type_show');
    }

    #[Route('/type-period/show', name: 'admin_type_period_show')]
    public function period(Request $request): Response
    {
        $this->breadcrumbs->addItem($this->translator->trans('catalog.label'));
        $this->breadcrumbs->addItem($this->translator->trans('period.label'));
        return $this->render('admin/pages/type/period/show.html.twig', [
            'typesPeriods' => $this->typeService->allPeriod(),
        ]);
    }

    #[Route('/type-period/new', name: 'admin_type_period_new')]
    public function newPeriod(Request $request): Response
    {
        $this->breadcrumbs->addItem($this->translator->trans('catalog.label'));
        $this->breadcrumbs->addItem($this->translator->trans('period.label'));
        $this->breadcrumbs->addItem($this->translator->trans('add.label'));
        $period = new PriceType();
        $form = $this->createForm(PriceTypeFormType::class, $period);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->typeService->addPeriod($period);
            $this->addFlash('success', $this->translator->trans('type.added.label'));
            return $this->redirectToRoute('admin_type_period_show');
        }
        return $this->renderForm('admin/pages/type/period/new.html.twig', ['form' => $form]);
    }

    #[Route('/type-period/edit/{id}', name: 'admin_type_period_edit')]
    public function editPeriod(Request $request, PriceType $period): Response
    {
        $this->breadcrumbs->addItem($this->translator->trans('catalog.label'));
        $this->breadcrumbs->addItem($this->translator->trans('period.label'));
        $this->breadcrumbs->addItem($this->translator->trans('edit.label'));
        $form = $this->createForm(PriceTypeFormType::class, $period);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->typeService->editPeriod($period);
            $this->addFlash('success', $this->translator->trans('type.edit.label'));
            return $this->redirectToRoute('admin_type_period_show');
        }
        return $this->renderForm('admin/pages/type/period/new.html.twig', ['form' => $form]);
    }
    #[Route('/period/delete/{id}', name: '')]
    public function deletePeriod(Request $request, PriceType $period): Response
    {
        if ($period) {
            $this->typeService->deletePeriod($period);
            $this->addFlash('success', $this->translator->trans('type.delete.label'));
            return $this->redirectToRoute('admin_type_period_show');
        }
        return $this->redirectToRoute('admin_type_period_show');
    }
}
