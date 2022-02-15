<?php

namespace App\Service\Manager;

use App\Entity\Settings;
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
    public function getLogoImageDir($dirImage): string
    {
        $userImageDir = $this->container->getParameter('logo_image_dir');
        return sprintf('%s-%s', $userImageDir, $dirImage);
    }
    public function updateUserImageCover(User $user, string $tempImageCoverFileName = null): User
    {
        $uploadsTempDir = $this->container->getParameter('uploads_temp_dir');
        if (!$tempImageCoverFileName) {
            return $user;
        }
        $userDir = $this->getUserImageDir($user);
        $userImageCover = $this->userImageManager->saveImageCoverForUser($userDir, $tempImageCoverFileName);
        $userImageCover->setUserCover($user);
        $user->addCover($userImageCover);
        return $user;
    }

    public function saveLogoImage(Settings $settings, string $tempImageFileName,$dirImage):Settings
    {
        $uploadedTempDir = $this->container->getParameter('logo_image_temp_dir');
        if (!$tempImageFileName){
            return $settings;
        }
        $logoDir = $this->getLogoImageDir($dirImage);
        $logoImage = $this->userImageManager->saveImageLogo($tempImageFileName,$logoDir);
        $settings->setLogo($logoImage);
        $settings->setLogoPath($dirImage);
        return $settings;
    }
}