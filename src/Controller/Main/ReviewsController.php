<?php

namespace App\Controller\Main;

use App\Entity\Reviews;
use App\Entity\User;
use App\Form\Main\Handler\UserFormHandler;
use App\Form\Main\User\ReviewsUserFormType;
use App\Service\Seo\SeoServiceInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class ReviewsController extends AbstractController
{


}