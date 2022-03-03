<?php

namespace App\Service\Admin\Type;

use App\Entity\PriceType;
use App\Entity\Type;

interface TypeServiceInterface
{
    public function add(Type $type): ?bool;

    public function edit(Type $type): ?bool;

    public function delete(Type $type): ?bool;

    public function all(): ?array;

    public function addPeriod(PriceType $priceType): ?bool;

    public function editPeriod(PriceType $priceType): ?bool;

    public function deletePeriod(PriceType $priceType): ?bool;

    public function allPeriod(): ?array;

    public function buildMenu(): ?array;

    public function showMenu(): void;

    public function buildMenuTypeProperty(): ?array;

    public function showMenuTypeProperty(): void;
}