<?php

namespace App\Form\Main\Handler;

use App\Entity\PricingPlan;
use App\Entity\UserPricingPlan;
use App\Repository\UserPricingPlanRepository;
use App\Service\Manager\PricingPlanUser\PricingPlanUserManager;
use App\Service\User\UserServiceInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class PricingPlanFormHandler
{
    public function __construct(private PricingPlanUserManager $manager)
    {
    }

    public function processUserPricingPlan(PricingPlan $plan): PricingPlan
    {
        return $this->manager->pricingPlanManager($plan);
    }
}