<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class DashboardController extends AbstractController
{
 #[Route('/dashboard', name: 'admin_dashboard')]
     public function index(): Response
     {
         //$breadcrumbs->addRouteItem("",'');
         return $this->render('admin/pages/dashboard/index.html.twig');
     }
}