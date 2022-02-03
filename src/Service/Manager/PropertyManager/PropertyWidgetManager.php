<?php

namespace App\Service\Manager\PropertyManager;

use App\Entity\PropertyRoomsWidget;
use App\Entity\PropertyRoomsWidgetAmenities;
use App\Repository\AmenitiesRepository;

class PropertyWidgetManager
{
    public function __construct(private AmenitiesRepository $repository)
    {
    }

    public function saveWidgetForPropertyAmenity(PropertyRoomsWidget $widget,$items): PropertyRoomsWidget
    {
        foreach ($items['amenityRoom'] as $item) {
            $roomsWidgetAmenity = new PropertyRoomsWidgetAmenities();
            $amenity = $this->repository->findOneBy(['id'=>$item]);
            if ($amenity){
               $a= $roomsWidgetAmenity->setAmenity($amenity);
               $widget->addPropertyRoomsWidgetAmenity($a);
            }
        }
        return $widget;
    }
}