<?php

namespace App\Service\Property;

use App\Entity\Amenities;
use App\Entity\Category;
use App\Entity\Property;
use App\Entity\PropertyAmenities;
use App\Entity\PropertyRoomsWidgetAmenities;
use App\Entity\Type;
use App\Repository\CategoryRepository;
use App\Repository\PropertyAmenitiesRepository;
use App\Repository\PropertyRepository;
use App\Repository\PropertyRoomsWidgetAmenitiesRepository;
use App\Repository\TypeRepository;
use App\Service\User\UserServiceInterface;
use Doctrine\ORM\NonUniqueResultException;

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
        $this->checkPropertyDuration();
        return $this->propertyRepository->propertiesPremium();
    }

    public function findSearchResultProperties(array $params): ?array
    {
        //dd($params);
        return $this->propertyRepository->searchProperties($params);
    }

    public function findAllByAgentListing(): ?array
    {
        $user = $this->userService->currentUser();
        return $this->propertyRepository->findAllByAgentListing($user);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findAllByAgentListingActive(): ?array
    {
        $user = $this->userService->currentUser();
        return $this->propertyRepository->findAllByAgentListingActive($user);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findAllByAgentListingViews(): ?int
    {
        $user = $this->userService->currentUser();
        return $this->propertyRepository->findAllByAgentListingViews($user);
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

    /**
     * @throws NonUniqueResultException
     */
    public function minMaxNumber(): array
    {
        return $this->propertyRepository->minMaxNumber();
    }

    public function searchKeywords(string $string): array
    {
        return $this->propertyRepository->searchKeywords($string);
    }

    public function wishlistProperties(array $params): array
    {
        return $this->propertyRepository->wishlistProperties($params);
    }

    public function findByTypesProperties(Type $type): ?array
    {
        return $this->propertyRepository->findByTypesProperties($type);
    }

    public function findByCategoryProperties(Category $category): ?array
    {
        return $this->propertyRepository->findByCategoryProperties($category);
    }

    public function featuredProperty(Property $property): array
    {
        return $this->propertyRepository->featured($property);
    }

    /**
     * @return void
     */
    private function checkPropertyDuration(): void
    {
        $properties = $this->propertyRepository->propertiesPremium();
        if ($properties) {
            foreach ($properties as $property) {
                $date = $property->getDuration()->format('d-m-Y');
                $newDate = new \DateTime();
                $newDate = $newDate->format('d-m-Y');
                if (strtotime($newDate) > strtotime($date)) {
                    $this->edit($property->setDuration(null));
                }
            }
        }
    }


    public function checkDurationProperty(): void
    {
        $properties = $this->findAllProperties();
        if ($properties) {
            foreach ($properties as $property) {
                $currentDate = new \DateTime();
                $duration = $property->getDuration();
                if (strtotime($currentDate->format('d-m-Y')) >= strtotime($duration->format('d-m-Y'))) {
                   $this->edit($property->setDuration(null));
                }
            }
        }
    }
}