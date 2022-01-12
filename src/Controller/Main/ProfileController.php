<?php

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'main_profile')]
    public function index(): Response
    {
        return $this->render('main/profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/edit', name: 'main_profile_edit')]
    public function edit(Request $request): Response
    {
        //$breadcrumbs->addRouteItem("",'');
        return $this->render('main/profile/edit.html.twig');
    }
}
