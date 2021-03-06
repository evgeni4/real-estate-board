<?php

namespace App\Service\User;

use App\Entity\Phone;
use App\Entity\User;
use App\Entity\UserPricingPlan;

interface UserServiceInterface
{
    public function add(User $user): ?bool;

    public function edit(User $user): ?bool;

    public function delete(User $user): ?bool;

    public function currentUser(): ?User;

    public function resetPassword(User $user): ?bool;

    public function PasswordHasher(User $user, $plainPassword): void;

    public function findById($uuid): ?User;

    public function pricingPlanByUser(): ?UserPricingPlan;

    public function checkPlanByUser(): void;

}