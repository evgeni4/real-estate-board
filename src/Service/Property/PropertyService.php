<?php

namespace App\Service\Property;

use App\Entity\Amenities;
use App\Entity\Property;
use App\Entity\PropertyAmenities;
use App\Entity\PropertyViewed;
use App\Entity\User;
use App\Repository\PropertyAmenitiesRepository;
use App\Repository\PropertyRepository;
use App\Repository\PropertyViewedRepository;
use App\Service\User\UserServiceInterface;
use Doctrine\ORM\NonUniqueResultException;

class PropertyService implements PropertyServiceInterface
{
    public function __construct(
        private PropertyRepository          $propertyRepository,
        private UserServiceInterface        $userService,
        private PropertyAmenitiesRepository $propertyAmenitiesRepository
    )
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

    public function findAllProperties(): ?array
    {
        return $this->propertyRepository->findBy([], ['id' => 'desc']);
    }

    public function findAllByAgentListing(): ?array
    {
        $user = $this->userService->currentUser();
        return $this->propertyRepository->findBy(['agent'=>$user]);
    }

    public function similarProperties(Property $property): ?array
    {
        return $this->propertyRepository->getSimilarProperties($property);
    }

    public function viewed(string $ip, Property $property): ?bool
    {
        if (null == $property->getViewed()) {
            $property->setViewed(1);
        } else {
            $property->setViewed($property->getViewed() + 1);
        }
        $this->edit($property);
        return true;
    }

    public function findOneByProductAmenities(Property $property,$id): ?PropertyAmenities
    {
        return $this->propertyAmenitiesRepository->findOneBy(['property'=>$property,'amenity'=>$id]);
    }
}