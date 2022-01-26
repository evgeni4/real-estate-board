<?php

namespace App\Service\Admin\Amenities;

use App\Entity\Amenities;

interface AmenitiesServiceInterface
{
    public function add(Amenities $amenities): ?bool;

    public function edit(Amenities $amenities): ?bool;

    public function delete(Amenities $amenities): ?bool;

    public function all(): ?array;
}