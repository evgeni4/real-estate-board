<?php

namespace App\Controller\Main\Dashboard;

use App\Service\Seo\SeoServiceInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/dashboard')]
class DashboardController extends AbstractController
{
    public function __construct(
        public Breadcrumbs          $breadcrumbs,
        public UserServiceInterface $userService,
        public SeoServiceInterface  $seoService,
        public TranslatorInterface  $translator
    )
    {
    }

    #[Route('/', name: 'main_dashboard')]
    public function show(): Response
    {
        $this->breadcrumbs->addItem('Dashboard');
        $this->seoService->seo('Dashboard', '', '', '', '', '');
        $user = $this->userService->currentUser();
        if (empty($user->getFirstName()) || empty($user->getLastName()) || empty($user->getPhone())) {
            return $this->redirectToRoute('main_profile');
        }
        return $this->render('main/dashboard/index.html.twig', [

        ]);
    }
}
