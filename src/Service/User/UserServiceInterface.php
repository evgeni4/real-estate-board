<?php

namespace App\Service\User;

use App\Entity\User;

interface UserServiceInterface
{
    public function add(User $user): ?bool;

    public function edit(User $user): ?bool;

    public function delete(User $user): ?bool;

    public function currentUser(): ?User;
}