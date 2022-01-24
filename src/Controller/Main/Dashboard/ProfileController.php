<?php

namespace App\Controller\Main\Dashboard;

use App\Entity\Reviews;
use App\Entity\User;
use App\Form\Main\Handler\UserFormHandler;
use App\Form\Main\User\ChangePasswordProfileFormType;
use App\Form\Main\User\ReviewsUserFormType;
use App\Form\Main\User\UserEditProfileFormType;
use App\Service\Seo\SeoServiceInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/dashboard/profile')]
class ProfileController extends AbstractController
{
    public function __construct(
        public Breadcrumbs          $breadcrumbs,
        public TranslatorInterface  $translator,
        public UserFormHandler      $userFormHandler,
        public UserServiceInterface $userService,
        public SeoServiceInterface  $seoService,
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
        $form = $this->createForm(UserEditProfileFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userFormHandler->processEditForm($user, $form);
            $userCover = $this->userFormHandler->processEditCoverForm($user, $form);
            $this->addFlash('success', $this->translator->trans('profile.changed.label'));
            return $this->redirectToRoute('main_profile');
        }

        $formChangePassword = $this->createForm(ChangePasswordProfileFormType::class, $user);
        $formChangePassword->handleRequest($request);
        if ($formChangePassword->isSubmitted() && $formChangePassword->isValid()) {
            $user = $this->userFormHandler->processEditPassword($user, $request);
            return $this->redirectToRoute('main_profile');
        }
        $this->breadcrumbs->addRouteItem($this->translator->trans('edit.profile.label'), 'main_profile');
        return $this->render('main/dashboard/profile/profile_edit.html.twig', [
            'form' => $form->createView(),
            'formChangePassword' => $formChangePassword->createView(),
        ]);
    }

}
