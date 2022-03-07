<?php

namespace App\Service\Property;

use App\Entity\Amenities;
use App\Entity\Category;
use App\Entity\Property;
use App\Entity\PropertyAmenities;
use App\Entity\PropertyRoomsWidgetAmenities;
use App\Entity\Type;
use App\Entity\User;

interface PropertyServiceInterface
{
    public function add(Property $property): ?bool;

    public function edit(Property $property): ?bool;

    public function delete(Property $property): ?bool;

    public function findAllByAgentListing(): ?array;

    public function findAllByAgentListingActive(): ?array;

    public function findAllByAgentListingViews(): ?int;

    public function similarProperties(Property $property): ?array;

    public function viewed(string $ip, Property $property): ?bool;

    public function findAllProperties(): ?array;

    public function findSearchResultProperties(array $params): ?array;

    public function findOneByProductAmenities(Property $property, $id): ?PropertyAmenities;

    public function amenityFromProperty(Property $property): array;

    public function findOneByRoomWidgetAmenities($widget, $id): ?PropertyRoomsWidgetAmenities;

    public function minMaxNumber(): array;

    public function searchKeywords(string $string): array;

    public function wishlistProperties(array $params): array;

    public function findByTypesProperties(Type $type):?array;

    public function findByCategoryProperties(Category $category):?array;

    public function featuredProperty(Property $property): array;

}