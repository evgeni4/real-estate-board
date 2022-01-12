<?php

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/dashboard')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'main_dashboard')]
    public function index(): Response
    {
        return $this->render('main/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

}
