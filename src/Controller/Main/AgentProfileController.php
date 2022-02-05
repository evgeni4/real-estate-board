<?php

namespace App\Controller\Main;

use App\Entity\Reviews;
use App\Entity\User;
use App\Form\Main\User\ReviewsUserFormType;
use App\Service\Admin\Settings\SettingsServiceInterface;
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
        public Breadcrumbs              $breadcrumbs,
        public TranslatorInterface      $translator,
        public UserServiceInterface     $userService,
        public SeoServiceInterface      $seoService,
        public ReviewsServiceInterface  $reviewsService,
        public PaginatorInterface       $paginator,
        public SettingsServiceInterface $settingsService,
    )
    {
    }

    #[Route('/show/{uuid}', name: 'main_profile_show')]
    public function show(Request $request, User $user): Response
    {
        $settings = $this->settingsService->findOneRecord();
        $this->seoService->seo(
            $settings->translate($request->getLocale())->getSiteName(),
            $settings->translate($request->getLocale())->getMetaKeywords(),
            $settings->translate($request->getLocale())->getMetaDescription(),
            $settings->translate($request->getLocale())->getSiteName(),
            $settings->translate($request->getLocale())->getMetaKeywords(),
            $settings->translate($request->getLocale())->getMetaDescription()
        );
        $this->breadcrumbs->addRouteItem('Home', 'app_home');
        $this->breadcrumbs->addRouteItem($this->translator->trans('real.estate.agent.label'), 'main_profile_show', ['uuid' => $user->getUuid()]);
        $this->breadcrumbs->addItem(ucfirst($user->getFirstName()) . ' ' . ucfirst($user->getLastName()));

        $reviewsFromAgent = $this->reviewsService->getReviewsFromUser($user);
        $query = $this->reviewsService->getCommentsFromUser($user);
        $review = new Reviews();
        $form = $this->createForm(ReviewsUserFormType::class, $review);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->reviewsService->add($review, $user);
            return $this->redirectToRoute('main_profile_show', ['uuid' => $user->getUuid()]);
        }
        $comments = $this->paginator->paginate($query, $request->query->getInt('page', 1), 2);
        return $this->renderForm('main/dashboard/profile/profile_show.html.twig', [
            'user' => $user,
            'comments' => $comments,
            'reviewsFromAgent' => $reviewsFromAgent,
            'form' => $form,
        ]);
    }

    /**
     * @param $uuid
     * @param $reviews
     * @param Request $request
     * @return Response
     */
    public function reviewsFromAuthor($uuid, $reviews, Request $request): Response
    {
        $user = $this->userService->findById($uuid);
        $reviewsFromAuthor = $this->reviewsService->ratingFromAuthor($reviews);
        return $this->render('main/_embed/_reviews/_review.html.twig',
            [
                'user' => $user,
                'reviewsFromAuthor' => $reviewsFromAuthor,
            ]);
    }

    public function reviewAgent($user): Response
    {
        $starsRating  = $this->reviewsService->getReviewsFromUser($user);
        return $this->render('main/_embed/_reviews/_review_agent.html.twig',['starsRating'=>$starsRating]);
    }



}