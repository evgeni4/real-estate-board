<?php

namespace App\Service\Property;

use App\Entity\Property;
use App\Entity\User;
use App\Repository\PropertyRepository;
use App\Service\User\UserServiceInterface;

class PropertyService implements PropertyServiceInterface
{
    public function __construct(private PropertyRepository $propertyRepository, private UserServiceInterface $userService)
    {
    }

    public function add(Property $property): ?bool
    {
        return $this->propertyRepository->insert($property);
    }

    public function edit(Property $property): ?bool
    {
        return $this->propertyRepository->update($property);
    }

    public function delete(Property $property): ?bool
    {
        // TODO: Implement delete() method.
    }

    public function findAllByAgentListing(int $start, int $limit): ?array
    {
        $user = $this->userService->currentUser();
        return $this->propertyRepository->findByAgentListing($user, $start, $limit);
    }

    public function similarProperties(Property $property): ?array
    {
        return $this->propertyRepository->getSimilarProperties($property);
    }
}