<?php

namespace App\Service\Admin\PricingPlan;

use App\Entity\PricingPlan;

interface PricingPlanServiceInterface
{
    public function add(PricingPlan $plan): ?bool;

    public function update(PricingPlan $plan): ?bool;

    public function delete(PricingPlan $plan): ?bool;

    public function findAll(): ?array;
}