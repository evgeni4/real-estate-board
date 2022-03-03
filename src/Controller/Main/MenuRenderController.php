<?php

namespace App\Controller\Main;

use App\Service\Admin\Type\TypeServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MenuRenderController extends AbstractController
{
    public function __construct(public TypeServiceInterface $typeService)
    {
    }

    public function menuNavigate(): Response
    {
         $menu = $this->typeService->showMenu();
        return $this->render('main/_embed/_main_header/_render_menu/menu.html.twig',
        [
            'menu'=>$menu
        ]
        );
    }

    public function categoryNavigate(): Response
    {
        $typeProperty = $this->typeService->showMenuTypeProperty();
        return $this->render('main/_embed/_main_header/_render_menu/menu.html.twig',
        [
            'typeProperty'=>$typeProperty
        ]
        );
    }
}