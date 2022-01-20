<?php

namespace App\Service\Manager;

use App\Entity\User;
use App\Entity\UserImage;
use App\Service\User\UserServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserManager
{
    public function __construct(
        public UserServiceInterface $userService,
        public ContainerInterface   $container,
        public UserImageManager     $userImageManager)
    {
    }

    public function save(User $user)
    {
        $this->userService->edit($user);
    }

    public function getUserImageDir(User $user)
    {
        $userImageDir = $this->container->getParameter('user_image_dir');
        return sprintf('%s-%s', $userImageDir, $user->getId());
    }

    public function updateUserImage(User $user, string $tempImageFileName = null): User
    {
        $uploadsTempDir = $this->container->getParameter('uploads_temp_dir');
        if (!$tempImageFileName) {
            return $user;
        }
        $userDir = $this->getUserImageDir($user);
        $userImage = $this->userImageManager->saveImageForUser($userDir, $tempImageFileName);
        $userImage->setUser($user);
        $user->addUserImage($userImage);
        return $user;
    }
}