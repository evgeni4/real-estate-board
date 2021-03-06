<?php

namespace App\Controller\Main\Dashboard;

use App\Service\Admin\Settings\SettingsServiceInterface;
use App\Service\Seo\SeoServiceInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/dashboard/messages')]
class MessagesController extends  AbstractController
{
    public function __construct(
        public Breadcrumbs          $breadcrumbs,
        public UserServiceInterface $userService,
        public SeoServiceInterface  $seoService,
        public TranslatorInterface  $translator,
        public SettingsServiceInterface $settingsService,
    )
    {
    }
 #[Route('/', name: 'main_messages')]
     public function messagesAction(Request $request): Response
 {
     $locale = $request->getLocale();
     $settings = $this->settingsService->findOneRecord();
     $this->seoService->seo(
         $settings->translate($locale)->getSiteName().'|'.'Dashboard',
         $settings->translate($locale)->getMetaKeywords(),
         $settings->translate($locale)->getMetaDescription(),
         'Dashboard',
         $settings->translate($locale)->getMetaDescription(),
         $settings->translate($locale)->getSiteName(),
     );
     $this->breadcrumbs->addItem($this->translator->trans('messages.label'));
         return $this->render('main/dashboard/messages/messages.html.twig');
     }
}