<?php

namespace App\Controller\Main;

use App\Entity\Reviews;
use App\Entity\User;
use App\Form\Main\User\ReviewsUserFormType;
use App\Service\Reviews\ReviewsServiceInterface;
use App\Service\Seo\SeoServiceInterface;
use App\Service\User\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/agent')]
class AgentProfileController extends AbstractController
{
    public function __construct(
        public Breadcrumbs             $breadcrumbs,
        public TranslatorInterface     $translator,
        public UserServiceInterface    $userService,
        public SeoServiceInterface     $seoService,
        public ReviewsServiceInterface $reviewsService,
        public PaginatorInterface      $paginator,
    )
    {
    }

    #[Route('/show/{uuid}', name: 'main_profile_show')]
    public function show(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $author = $this->userService->currentUser();
        $reviews = $this->reviewsService->getReviewsFromUser($user);
        $query = $this->reviewsService->getCommentsFromUser($user);
        $review = new Reviews();
        $form = $this->createForm(ReviewsUserFormType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setUser($user);
            $review->setAuthor($author);
            $entityManager->persist($review);
            $entityManager->flush();
            return $this->redirectToRoute('main_profile_show', ['uuid' => $user->getUuid()]);
        }
        $comments = $this->paginator->paginate($query, $request->query->getInt('page', 1), 2);
        return $this->renderForm('main/dashboard/profile/profile_show.html.twig', [
            'user' => $user,
            'reviews' => $reviews,
            'comments' => $comments,
            'form' => $form,
        ]);
    }

    public function reviews($uuid): Response
    {
        $user = $this->userService->findById($uuid);
        $reviews = $this->reviewsService->getReviewsFromUser($user);
        return $this->render('main/_embed/_reviews/_review.html.twig',
        [
            'reviews' => $reviews,
            'user' => $user,
        ]);
    }
}