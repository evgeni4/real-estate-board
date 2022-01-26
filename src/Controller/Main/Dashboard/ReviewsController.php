<?php

namespace App\Controller\Main\Dashboard;

use App\Service\Reviews\ReviewsServiceInterface;
use App\Service\Seo\SeoServiceInterface;
use App\Service\User\UserServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/dashboard/reviews')]
class ReviewsController extends AbstractController
{
    public function __construct(
        private Breadcrumbs          $breadcrumbs,
        private UserServiceInterface $userService,
        private SeoServiceInterface  $seoService,
        private TranslatorInterface  $translator,
        private ReviewsServiceInterface $reviewsService,
        private PaginatorInterface       $paginator,
    )
    {
    }

    #[Route('/', name: 'main_reviews_show')]
    public function show(Request $request): Response
    {
        $this->breadcrumbs->addItem($this->translator->trans('reviews.label'));
        $this->seoService->seo($this->translator->trans('reviews.label'), '', '', '', '', '');
        $user = $this->userService->currentUser();
        $query = $this->reviewsService->getCommentsFromUser($user);
        $comments = $this->paginator->paginate($query, $request->query->getInt('page', 1), 2);
        return $this->render('main/dashboard/reviews/show.html.twig', [
        'comments'=>$comments
        ]);
    }
}