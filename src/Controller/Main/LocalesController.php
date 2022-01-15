<?php

namespace App\Controller\Main;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocalesController extends AbstractController
{
    #[Route("/language/{locale}", name: "change_language")]
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
        return $this->render('main/_embed/locales/locales.html.twig',['locales'=>$locales,'currencies'=>$currencies]);
    }
    #[Route("/currency/{currency}", name:"change_currency")]
    /**
     * @param $currency
     * @param Request $request
     * @return Response
     */
    public function currency($currency ,Request $request): Response
    {
        // $request->getSession()->set('clang', $locale);
        $request->getSession()->set('_currency', $currency);
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}