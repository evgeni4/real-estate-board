<?php

namespace App\Form\Main\Handler;

use App\Entity\User;
use App\Entity\UserImage;
use App\Repository\UserCoversRepository;
use App\Repository\UserImageRepository;
use App\Service\File\FileSaver;
use App\Service\Manager\UserImageManager;
use App\Service\Manager\UserManager;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class UserFormHandler extends AbstractController
{
    public function __construct(
        public UserManager          $userManager,
        public UserImageManager     $userImageManager,
        public FileSaver            $fileSaver,
        public UserServiceInterface $userService,
        public UserImageRepository  $userImageRepository,
        public UserCoversRepository $coversRepository,
        public TranslatorInterface  $translator
    )
    {
    }

    public function processEditForm(User $user, Form $form): User
    {
        $user = $this->userService->currentUser();
        $userImage = $this->userImageRepository->findOneBy(['user' => $user->getId()]);

        $newImageFile = $form->get('newImage')->getData();
        if ($newImageFile != null && $userImage != null) {
            $user = $userImage->getUser();
            $userImageDir = $this->userManager->getUserImageDir($user);
            $this->userImageManager->removeImageFromUser($userImage, $userImageDir);
        }
        $tempImageFileName = $newImageFile ? $this->fileSaver->saveUploadedFileIntoTemp($newImageFile) : null;
        $this->userManager->updateUserImage($user, $tempImageFileName);
        $this->userManager->save($user);
        return $user;
    }

    public function processEditCoverForm(User $user, Form $form): User
    {
        $user = $this->userService->currentUser();
        $newImageCoverFile = $form->get('newImageCover')->getData();
        $userImageCover = $this->coversRepository->findOneBy(['userCover' => $user->getId()]);
        if ($newImageCoverFile != null && $userImageCover != null) {
            $user = $userImageCover->getUserCover();
            $userImageDir = $this->userManager->getUserImageDir($user);
            $this->userImageManager->removeCoverFromUser($userImageCover, $userImageDir);
        }
        $tempImageCoverFileName = $newImageCoverFile ? $this->fileSaver->saveUploadedCoverFileIntoTemp($newImageCoverFile) : null;
        $this->userManager->updateUserImageCover($user, $tempImageCoverFileName);

        $this->userManager->save($user);
        return $user;
    }

    public function processEditPassword(User $user, Request $request): User
    {
        $password = $user->getPassword();
        $oldPassword = $request->request->get('change_password_profile_form')['current_password'];
        if (password_verify($oldPassword, $password)) {
            $newPassword = $request->request->get('change_password_profile_form')['password']['first'];
            $user->setPassword($newPassword);
            $this->userService->resetPassword($user);
            $this->addFlash('success', $this->translator->trans('password.changed.label'));
        } else {
            $this->addFlash('warning', $this->translator->trans('password.old.label'));
        }
        return $user;
    }
}