<?php

namespace App\Service\User;

use App\Entity\User;
use App\Exception\Security\EmptyUserPlainPassword;
use App\Repository\ResetPasswordRequestRepository;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class UserService implements UserServiceInterface
{
    public function __construct(
        private Security                       $security,
        private UserRepository                 $userRepository,
        private UserPasswordHasherInterface    $userPasswordHasher,
        private ResetPasswordRequestRepository $passwordRequestRepository
    )
    {
    }

    public function add(User $user): ?bool
    {
        $this->PasswordHasher($user,$user->getPassword());
        return $this->userRepository->insert($user);
    }

    public function edit(User $user): ?bool
    {
        return $this->userRepository->update($user);
    }

    public function delete(User $user): ?bool
    {
        return $this->userRepository->remove($user);
    }

    public function currentUser(): ?User
    {
        return $this->security->getUser();
    }

    public function resetPassword(User $user): ?bool
    {
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $user->getPassword()
            )
        );
        return $this->passwordRequestRepository->resetPassword($user);
    }

    /**
     * @param User $user
     * @param string $plainPassword
     */
    public function PasswordHasher(User $user, $plainPassword ):void
    {
        $newPassword = trim($plainPassword);
        if (!$newPassword) {
            throw  new EmptyUserPlainPassword('Empty user password!');
        }
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $newPassword
            )
        );
    }
}