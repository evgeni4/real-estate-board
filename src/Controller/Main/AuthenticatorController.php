<?php

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticatorController extends AbstractController
{
    #[Route('/auth', name: 'main_auth')]
    public function authenticator(): Response
    {
        return $this->render('main/authenticator/authenticator.html.twig');
    }

}
