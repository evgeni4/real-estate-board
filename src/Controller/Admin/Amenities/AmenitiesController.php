<?php

namespace App\Controller\Admin\Amenities;

use App\Entity\Amenities;
use App\Form\Admin\Amenities\AmenitiesFormType;
use App\Service\Admin\Amenities\AmenitiesServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/admin/amenities')]
class AmenitiesController extends AbstractController
{
    public function __construct(
        private AmenitiesServiceInterface $amenitiesService,
        private TranslatorInterface       $translator,
        private Breadcrumbs               $breadcrumbs,
    )
    {
    }

    #[Route('/show', name: 'admin_amenities_show')]
    public function show(): Response
    {
        $this->breadcrumbs->addItem($this->translator->trans('catalog.label'));
        $this->breadcrumbs->addItem($this->translator->trans('amenities.label'));
        $amenities = $this->amenitiesService->all();
        return $this->render('admin/pages/amenities/show.html.twig', [
            'amenitiesAll' => $amenities
        ]);
    }

    #[Route('/new', name: 'admin_amenities_new')]
    public function new(Request $request ): Response
    {

        $this->breadcrumbs->addItem($this->translator->trans('catalog.label'));
        $this->breadcrumbs->addItem($this->translator->trans('amenities.label'));
        $this->breadcrumbs->addItem($this->translator->trans('add.label'));
        $amenities = new Amenities();
        $form = $this->createForm(AmenitiesFormType::class, $amenities);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->amenitiesService->add($amenities);
            $this->addFlash('success', $this->translator->trans('amenities.added.label'));
            return $this->redirectToRoute('admin_amenities_show');
        }
        return $this->renderForm('admin/pages/amenities/new.html.twig',
            [
                'form' => $form,
            ]);
    }

    #[Route('/edit/{uuid}', name: 'admin_amenities_edit')]
    public function edit(Amenities $amenities, Request $request): Response
    {
        $this->breadcrumbs->addItem($this->translator->trans('catalog.label'));
        $this->breadcrumbs->addItem($this->translator->trans('amenities.label'));
        $this->breadcrumbs->addItem($this->translator->trans('edit.label'));
        $form = $this->createForm(AmenitiesFormType::class, $amenities);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->amenitiesService->edit($amenities);
            $this->addFlash('success', $this->translator->trans('amenities.edit.label'));
            return $this->redirectToRoute('admin_amenities_show');
        }
        return $this->render('admin/pages/amenities/edit.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    #[Route('/delete/{id}', name: 'admin_amenities_delete')]
    public function delete(Request $request, Amenities $amenities): Response
    {
        $this->amenitiesService->delete($amenities);
        $this->addFlash('success', $this->translator->trans('amenities.delete.label'));
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
