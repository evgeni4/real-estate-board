<?php

namespace App\Service\Property;

use App\Entity\Amenities;
use App\Entity\Property;
use App\Entity\PropertyAmenities;
use App\Entity\PropertyRoomsWidgetAmenities;
use App\Repository\CategoryRepository;
use App\Repository\PropertyAmenitiesRepository;
use App\Repository\PropertyRepository;
use App\Repository\PropertyRoomsWidgetAmenitiesRepository;
use App\Repository\TypeRepository;
use App\Service\User\UserServiceInterface;

class PropertyService implements PropertyServiceInterface
{
    public function __construct(
        private PropertyRepository                     $propertyRepository,
        private UserServiceInterface                   $userService,
        private PropertyAmenitiesRepository            $propertyAmenitiesRepository,
        private PropertyRoomsWidgetAmenitiesRepository $propertyRoomsWidgetAmenitiesRepository,
        private TypeRepository                         $typesRepository
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
        return $this->propertyRepository->findBy(['agent' => $user], ['id' => 'desc']);
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

    public function findOneByProductAmenities(Property $property, $id): ?PropertyAmenities
    {
        return $this->propertyAmenitiesRepository->findOneBy(['property' => $property, 'amenity' => $id]);
    }

    public function amenityFromProperty(Property $property): array
    {
        $a = [];
        foreach ($property->getPropertyRoomsWidgets()->getValues() as $item) {
            $a[$item->getId()] = [];
            foreach ($item->getPropertyRoomsWidgetAmenities()->getValues() as $value) {
                $a[$item->getId()][] = $value->getChecked();
            }
        }

        return $a;
    }

    public function findOneByRoomWidgetAmenities($widget, $id): ?PropertyRoomsWidgetAmenities
    {
        return $this->propertyRoomsWidgetAmenitiesRepository->findOneBy(['roomsWidget' => $widget, 'amenity' => $id]);
    }

    public function findForRentAllProperties(string $param = null): ?array
    {
        $type = null;
        foreach ($this->typesRepository->findAll() as $item) {
            $pos = str_contains($item->translate('en')->getTitle(), $param);
            if ($pos) {
                $type = $item;
                break;
            }
        }
        return $this->propertyRepository->findBy(['types' => $type]);
    }
}