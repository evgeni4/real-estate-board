<?php

namespace App\Service\Reviews;

use App\Entity\Reviews;
use App\Entity\User;
use App\Repository\ReviewsRepository;
use App\Service\User\UserServiceInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Routing\RouterInterface;
class ReviewsService implements ReviewsServiceInterface
{
    public function __construct(
        public ReviewsRepository     $reviewsRepository,
        public TranslatorInterface   $translator,
        public UserServiceInterface  $userService,
        public FlashBagInterface     $flash,
        public RouterInterface       $router
    )
    {
    }

    public function add(Reviews $reviews, User $user): ?bool
    {
        $author = $this->userService->currentUser();
        $reviews->setAuthor($author);
        $reviews->setUser($user);
        $this->checkUserAndAuthor($user,$author,$reviews);
        return true;
    }

    public function getCommentsFromUser(User $user): array
    {
        return $this->reviewsRepository->findBy(['user' => $user], ['id' => 'DESC']);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getReviewsFromUser($user): ?array
    {
        $reviews = [];
        $ratings = $this->reviewsRepository->reviewsFromUser($user);
        if ($ratings) {
            $rating = floatval($ratings['rating']);
            $grade = (
            ($rating <= 1.99) ? 1 :
                (($rating <= 2.99) ? 2 :
                    (($rating <= 3.99) ? 3 :
                        (($rating <= 4.99) ? 4 : 5)))
            );
            $review = floatval($ratings['rating']);
            $rating = (
            ($review <= 1.99) ? $this->translator->trans('very.bad.label') :
                (($review <= 2.99) ? $this->translator->trans('fair.label') :
                    (($review <= 3.99) ? $this->translator->trans('average.label') :
                        (($review <= 4.99) ? $this->translator->trans('good.label') : $this->translator->trans('excellent.label'))))
            );
            $reviews['stars-rating'] = $grade;
            $reviews['stars-title'] = $rating;
            $reviews['count'] = intval($ratings['count']);
        }

        return $reviews;
    }

    /**
     * @param Reviews $reviews
     * @return array|null
     */
    public function ratingFromAuthor(Reviews $reviews): ?array
    {
        $reviewsByAuthor = [];
        $review = $reviews->getRating();
        $grade = (
        ($review <= 1.99) ? 1 :
            (($review <= 2.99) ? 2 :
                (($review <= 3.99) ? 3 :
                    (($review <= 4.99) ? 4 : 5)))
        );
        $rating = (
        ($review <= 1.99) ? $this->translator->trans('very.bad.label') :
            (($review <= 2.99) ? $this->translator->trans('fair.label') :
                (($review <= 3.99) ? $this->translator->trans('average.label') :
                    (($review <= 4.99) ? $this->translator->trans('good.label') : $this->translator->trans('excellent.label'))))
        );
        $reviewsByAuthor['stars-rating'] = $grade;
        $reviewsByAuthor['stars-title'] = $rating;
        return $reviewsByAuthor;
    }

    /**
     * @param User $user
     * @param $author
     * @param $reviews
     * @return Response|null
     */
    private function checkUserAndAuthor(User $user,$author,$reviews): ?bool
    {

        if (null == $author || $author->getFirstName() == null || $author->getLastName() == null) {
            $this->flash->add('warning', $this->translator->trans('complete.your.profile.label'));
            return false;
         }
        if ($author->getId() == $user->getId()) {
            $this->flash->add('warning', $this->translator->trans('cannot.comments.your.profile.label'));
            return false;
        }
        $this->reviewsRepository->insert($reviews);
        $this->flash->add('success', $this->translator->trans('review.added.label'));
        return true;
    }
}