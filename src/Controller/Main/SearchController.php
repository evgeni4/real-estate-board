<?php

namespace App\Controller\Main;

use App\Form\Main\Search\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends AbstractController
{
    public function search(): Response
    {
        $form = $this->createForm(SearchType::class);
        return $this->render('main/_embed/_search/_form_search.html.twig',['form'=>$form->createView()]);
    }
}