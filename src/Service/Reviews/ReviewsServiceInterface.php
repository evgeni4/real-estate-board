<?php

namespace App\Service\Reviews;

use App\Entity\Reviews;
use App\Entity\User;

interface ReviewsServiceInterface
{
    public function add(Reviews $reviews, User $user): ?bool;

    public function getReviewsFromUser($user): ?array;

    public function getCommentsFromUser(User $user);

    public function ratingFromAuthor(Reviews $reviews): ?array;
}