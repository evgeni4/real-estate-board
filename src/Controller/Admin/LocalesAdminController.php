<?php

namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route("/admin/dashboard")]
class LocalesAdminController extends AbstractController
{
    #[Route("/language/{locale}", name: "admin_change_language")]
    /**
     * @param $locale
     * @param Request $request
     * @return RedirectResponse
     */
    public function changeLocale($locale, Request $request): Response
    {
        $request->getSession()->set('clang', $locale);
        $request->getSession()->set('_locales', $locale);
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function showLocalesLanguage(): Response
    {
        $locales = $this->getParameter('locales');
        $currencies = $this->getParameter('locale_currencies');
        return $this->render('admin/_embed/locales/locales.html.twig',['locales'=>$locales,'currencies'=>$currencies]);
    }

}