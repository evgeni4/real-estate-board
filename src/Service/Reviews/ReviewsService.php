<?php

namespace App\Service\Reviews;

use App\Entity\User;
use App\Repository\ReviewsRepository;
use Doctrine\ORM\NonUniqueResultException;

class ReviewsService implements ReviewsServiceInterface
{
    public function __construct(public ReviewsRepository $reviewsRepository)
    {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getReviewsFromUser(User $user)
    {
        return $this->reviewsRepository->reviewsFromUser($user);
    }

    public function getCommentsFromUser(User $user): array
    {
        return $this->reviewsRepository->findBy(['user'=>$user]);
    }
}