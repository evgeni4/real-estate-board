<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/admin')]
class DashboardController extends AbstractController
{
 #[Route('/dashboard', name: 'admin_dashboard')]
     public function index(Breadcrumbs $breadcrumbs): Response
     {
         $breadcrumbs->addRouteItem("Dashboard",'admin_dashboard');

         return $this->render('admin/pages/dashboard/index.html.twig');
     }
}