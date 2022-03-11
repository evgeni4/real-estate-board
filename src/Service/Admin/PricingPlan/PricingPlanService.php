<?php

namespace App\Service\Admin\PricingPlan;

use App\Entity\PricingPlan;
use App\Repository\PricingPlanRepository;

class PricingPlanService implements PricingPlanServiceInterface
{
    public function __construct(private PricingPlanRepository $planRepository)
    {
    }

    public function add(PricingPlan $plan): ?bool
    {
        return  $this->planRepository->add($plan);
    }

    public function update(PricingPlan $plan): ?bool
    {
         return  $this->planRepository->edit($plan);
    }

    public function delete(PricingPlan $plan): ?bool
    {
         return  $this->planRepository->delete($plan);
    }

    public function findAll(): ?array
    {
        return  $this->planRepository->findAll();
    }

    public function findActivePlans(): ?array
    {
        return  $this->planRepository->findBy(['published'=>true]);
    }
}