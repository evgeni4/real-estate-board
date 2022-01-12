<?php

namespace App\Service\Factory;

use App\Entity\User;
use League\OAuth2\Client\Provider\FacebookUser;

class UserFactory
{
    /**
     * @param FacebookUser $facebookUser
     * @return User
     */
    public static function createUserFromFacebookUser(FacebookUser $facebookUser): User
    {
        $user = new User();
        $user->setEmail($facebookUser->getEmail());
        $user->setFirstName($facebookUser->getFirstName());
        $user->setLastName($facebookUser->getLastName());
        $user->setFacebookId($facebookUser->getId());
        $user->setIsVerified(true);
        return $user;
    }
}