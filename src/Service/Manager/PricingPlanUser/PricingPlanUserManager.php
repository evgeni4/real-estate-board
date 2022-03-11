<?php

namespace App\Service\Manager\PricingPlanUser;

use App\Entity\PricingPlan;
use App\Entity\UserPricingPlan;
use App\Repository\UserPricingPlanRepository;
use App\Service\User\UserServiceInterface;

class PricingPlanUserManager
{
    public function __construct(private UserServiceInterface $userService, private UserPricingPlanRepository $userPricingPlanRepository)
    {
    }
    public function pricingPlanManager (PricingPlan $plan): PricingPlan
    {
        $user = $this->userService->currentUser();
        foreach ($this->userPricingPlanRepository->findAll() as $item) {
            $this->userPricingPlanRepository->update($item->setValidDate(null));
        }
        $userPlan = new UserPricingPlan();
        $date = $userPlan->getValidDate()->modify('+30 days');
        $userPlan->setValidDate($date);
        $userPlan->setPricingPlan($plan);
        $userPlan->setUser($user);
        $user->addUserPricingPlan($userPlan);
        $this->userPricingPlanRepository->update($userPlan);
        return $plan;
    }
}