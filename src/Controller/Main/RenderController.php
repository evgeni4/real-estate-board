<?php

namespace App\Controller\Main;

use App\Service\Admin\Settings\SettingsServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RenderController extends AbstractController
{
    public function __construct(private SettingsServiceInterface $settingsService)
    {
    }

    public function footerFirst(): Response
     {
         $settings =$this->settingsService->findOneRecord();
         return $this->render('main/_embed/_main_footer/_embed/footer.html.twig',['settings'=>$settings]);
     }
}