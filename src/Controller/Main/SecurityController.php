<?php

namespace App\Controller\Main;

use App\Service\Admin\Settings\SettingsServiceInterface;
use App\Service\Seo\SeoServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    public function __construct(
        public SeoServiceInterface      $seoService,
        public SettingsServiceInterface $settingsService,
        public TranslatorInterface $translator
    )
    {
    }
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils,Request $request): Response
    {
        $settings = $this->settingsService->findOneRecord();
        $this->seoService->seo(
            $this->translator->trans('sign.in.label'),
            $settings->translate($request->getLocale())->getMetaKeywords(),
            $settings->translate($request->getLocale())->getMetaDescription(),
            $settings->translate($request->getLocale())->getSiteName(),
            $settings->translate($request->getLocale())->getMetaKeywords(),
            $settings->translate($request->getLocale())->getMetaDescription()
        );
         if ($this->getUser()) {
             return $this->redirectToRoute('app_home');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('main/security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
