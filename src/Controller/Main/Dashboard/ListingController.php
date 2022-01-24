<?php

namespace App\Controller\Main\Dashboard;

use App\Service\Seo\SeoServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/dashboard')]
class ListingController extends AbstractController
{
    public function __construct(
        public Breadcrumbs          $breadcrumbs,
        public TranslatorInterface  $translator,
        public SeoServiceInterface  $seoService,
    )
    {
    }
 #[Route('/add', name: 'main_add_listing')]
     public function index(): Response
     {
        $this->breadcrumbs->addItem('Add listing');
         return $this->render('main/dashboard/listing/new.html.twig');
     }
}