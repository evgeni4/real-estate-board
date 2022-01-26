<?php

namespace App\Service\Admin\Amenities;

use App\Entity\Amenities;
use App\Repository\AmenitiesRepository;

class AmenitiesService implements AmenitiesServiceInterface
{
    public function __construct(public AmenitiesRepository $amenitiesRepository)
    {
    }

    public function add(Amenities $amenities): ?bool
    {
        return $this->amenitiesRepository->insert($amenities);
    }

    public function edit(Amenities $amenities): ?bool
    {
        return $this->amenitiesRepository->update($amenities);
    }

    public function delete(Amenities $amenities): ?bool
    {
        return $this->amenitiesRepository->remove($amenities);
    }

    public function all(): ?array
    {
        return $this->amenitiesRepository->findAll();
    }
}