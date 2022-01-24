<?php

namespace App\Service\Reviews;

use App\Entity\User;

interface ReviewsServiceInterface
{
public function getReviewsFromUser(User $user);

    public function getCommentsFromUser(User $user);
}