<?php

namespace App\Controller\Admin;

use App\Entity\Settings;
use App\Form\Admin\Handler\SettingsFormHandler;
use App\Form\Admin\SettingsFormType;
use App\Service\Admin\Settings\SettingsServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route("admin/settings")]
class SystemSettings extends AbstractController
{
    public function __construct(
        private TranslatorInterface      $translator,
        private Breadcrumbs              $breadcrumbs,
        private SettingsServiceInterface $settingsService,
        private SettingsFormHandler      $settingsFormHandler
    )
    {
    }

    #[Route('/show', name: 'admin_settings_show')]
    public function show(): Response
    {
        $this->breadcrumbs->addRouteItem("Dashboard", 'admin_dashboard');
        $this->breadcrumbs->addItem($this->translator->trans('settings.label'));
        return $this->render('admin/pages/settings/show.html.twig',
            [
                'settings' => $this->settingsService->findOneRecord()
            ]
        );
    }

    #[Route('/new', name: 'admin_settings_new')]
    public function new(Request $request): Response
    {
        $this->breadcrumbs->addRouteItem("Dashboard", 'admin_dashboard');
        $this->breadcrumbs->addRouteItem($this->translator->trans('settings.label'), 'admin_settings_show');
        $this->breadcrumbs->addItem($this->translator->trans('add.label'));
        $settings = new Settings();
        $form = $this->createForm(SettingsFormType::class, $settings);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Settings added successfully');
            $this->settingsService->add($settings);
            return $this->redirectToRoute('admin_settings_show');
        }
        return $this->render('admin/pages/settings/new.html.twig', ['form' => $form->createView()]);
    }


    #[Route('/{id}/edit', name: 'admin_settings_edit')]
    public function edit(Settings $settings, Request $request): Response
    {
        $this->breadcrumbs->addRouteItem("Dashboard", 'admin_dashboard');
        $this->breadcrumbs->addRouteItem($this->translator->trans('settings.label'), 'admin_settings_show');;
        $this->breadcrumbs->addItem($this->translator->trans('edit.label'));
        $form = $this->createForm(SettingsFormType::class, $settings);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $settings = $this->settingsFormHandler->processEditForm($settings, $form);
            $this->addFlash('success', $this->translator->trans('settings.changed.label'));
            $this->settingsService->update($settings);
            return $this->redirectToRoute('admin_settings_edit',['id'=>$settings->getId()]);
        }
        return $this->renderForm('admin/pages/settings/new.html.twig', ['form' => $form,'settings'=>$settings]);
    }
}