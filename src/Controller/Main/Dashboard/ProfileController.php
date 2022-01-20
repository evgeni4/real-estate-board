<?php

namespace App\Controller\Main\Dashboard;

use App\Entity\User;
use App\Entity\UserImage;
use App\Form\Main\ChangePasswordFormType;
use App\Form\Main\Handler\UserFormHandler;
use App\Form\Main\UserEditProfileFormType;
use App\Repository\UserImageRepository;
use App\Service\Manager\UserImageManager;
use App\Service\Manager\UserManager;
use App\Service\Seo\SeoServiceInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/dashboard/profile')]
class ProfileController extends AbstractController
{
    public function __construct(
        public Breadcrumbs $breadcrumbs,
        public TranslatorInterface $translator,
        public UserFormHandler $userFormHandler,
        public UserServiceInterface $userService,
        public SeoServiceInterface $seoService,
    )
    {
    }

    #[Route('/edit', name: 'main_profile')]
    public function edit(Request $request): Response
    {
        $this->seoService->seo(
            $this->translator->trans('edit.profile.label'),
            $this->translator->trans('edit.profile.label'),
            $this->translator->trans('edit.profile.label'),
            $this->translator->trans('edit.profile.label'),
            $this->translator->trans('edit.profile.label'),
            $this->translator->trans('edit.profile.label'),
        );
        $user = $this->userService->currentUser();
        $password = $user->getPassword();
        $form = $this->createForm(UserEditProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userFormHandler->processEditForm($user, $form);
            $this->addFlash('success', $this->translator->trans('profile.changed.label'));
            return $this->redirectToRoute('main_profile');
        }

        $formChangePassword = $this->createForm(ChangePasswordFormType::class, $user);
        $formChangePassword->handleRequest($request);

        if ($formChangePassword->isSubmitted() && $formChangePassword->isValid()) {
            $oldPassword = $request->request->get('change_password_form')['current_password'];
            if (password_verify($oldPassword, $password)) {
                $this->userService->PasswordHasher($user, $user->getPassword());
                $this->userService->edit($user);
                $this->addFlash('success', $this->translator->trans('password.changed.label'));
                return $this->redirectToRoute('main_profile');
            }
            $this->addFlash('warning', $this->translator->trans('password.old.label'));
            return $this->redirectToRoute('main_profile');
        }
        $this->breadcrumbs->addRouteItem($this->translator->trans('edit.profile.label'), 'main_profile');
        return $this->render('main/dashboard/profile/profile_edit.html.twig', [
            'form' => $form->createView(),
            'formChangePassword' => $formChangePassword->createView(),
        ]);
    }

//    #[Route('/delete/{id}', name: 'main_profile_del')]
//    public function delete(UserImage $userImage, UserManager $userManager, UserImageManager $userImageManager)
//    {
//        $user = $userImage->getUser();
//        $userImageDir = $userManager->getUserImageDir($user);
//        $userImageManager->removeImageFromUser($userImage, $userImageDir);
//        return $this->redirectToRoute('main_profile');
//    }
}
