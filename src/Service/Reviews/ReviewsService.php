<?php

namespace App\Service\Reviews;

use App\Entity\Reviews;
use App\Entity\User;
use App\Repository\ReviewsRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Contracts\Translation\TranslatorInterface;

class ReviewsService implements ReviewsServiceInterface
{
    public function __construct(public ReviewsRepository $reviewsRepository,public TranslatorInterface $translator)
    {
    }
    public function add(Reviews $reviews): ?bool{
        return $this->reviewsRepository->insert($reviews);
    }
    public function getCommentsFromUser(User $user): array
    {
        return $this->reviewsRepository->findBy(['user' => $user],['id'=>'DESC']);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getReviewsFromUser($user): ?array
    {
        $reviews =[];
        $ratings = $this->reviewsRepository->reviewsFromUser($user);
        $rating = floatval($ratings['rating']);
        $grade=(
        ($rating <= 1.99) ? 1 :
            (($rating <= 2.99) ? 2 :
                (($rating <= 3.99) ? 3 :
                    (($rating <= 4.99) ? 4 : 5)))
        );
        $review =  floatval($ratings['rating']);
        $rating=  (
        ($review <= 1.99) ? $this->translator->trans('very.bad.label') :
            (($review <= 2.99) ? $this->translator->trans('fair.label') :
                (($review <= 3.99) ? $this->translator->trans('average.label') :
                    (($review <= 4.99) ? $this->translator->trans('good.label') : $this->translator->trans('excellent.label'))))
        );
        $reviews['stars-rating']=$grade;
        $reviews['stars-title']=$rating;
        $reviews['count']=intval($ratings['count']);

        return $reviews;
    }

    /**
     * @param Reviews $reviews
     * @return array|null
     */
    public function ratingFromAuthor(Reviews $reviews): ?array
    {
        $reviewsByAuthor =[];
        $review = $reviews->getRating();
        $grade=(
        ($review <= 1.99) ? 1 :
            (($review <= 2.99) ? 2 :
                (($review <= 3.99) ? 3 :
                    (($review <= 4.99) ? 4 : 5)))
        );
        $rating=  (
        ($review <= 1.99) ? $this->translator->trans('very.bad.label') :
            (($review <= 2.99) ? $this->translator->trans('fair.label') :
                (($review <= 3.99) ? $this->translator->trans('average.label') :
                    (($review <= 4.99) ? $this->translator->trans('good.label') : $this->translator->trans('excellent.label'))))
        );
        $reviewsByAuthor['stars-rating']=$grade;
        $reviewsByAuthor['stars-title']=$rating;
        return $reviewsByAuthor;
    }
}