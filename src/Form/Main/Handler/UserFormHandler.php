<?php

namespace App\Form\Main\Handler;

use App\Entity\User;
use App\Entity\UserImage;
use App\Repository\UserImageRepository;
use App\Service\File\FileSaver;
use App\Service\Manager\UserImageManager;
use App\Service\Manager\UserManager;
use App\Service\User\UserServiceInterface;
use Symfony\Component\Form\Form;

class UserFormHandler
{
    public function __construct(
        public UserManager $userManager,
        public UserImageManager $userImageManager,
        public FileSaver $fileSaver,
        public UserServiceInterface $userService,
        public UserImageRepository $userImageRepository
    )
    {
    }

    public function processEditForm(User $user, Form $form): User
    {
        $user = $this->userService->currentUser();
        $userImage = $this->userImageRepository->findOneBy(['user'=>$user->getId()]);

        $newImageFile = $form->get('newImage')->getData();
        if ($newImageFile!=null && $userImage!=null){
            $user = $userImage->getUser();
            $userImageDir = $this->userManager->getUserImageDir($user);
            $this->userImageManager->removeImageFromUser($userImage, $userImageDir);
        }
        $tempImageFileName = $newImageFile ? $this->fileSaver->saveUploadedFileIntoTemp($newImageFile) : null;
        $this->userManager->updateUserImage($user, $tempImageFileName);
        $this->userManager->save($user);
        return $user;
    }

}