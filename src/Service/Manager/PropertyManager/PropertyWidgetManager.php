<?php

namespace App\Service\Manager\PropertyManager;

use App\Entity\PropertyRoomsWidget;
use App\Entity\PropertyRoomsWidgetAmenities;
use App\Repository\AmenitiesRepository;
use App\Repository\PropertyRoomsWidgetAmenitiesRepository;

class PropertyWidgetManager
{
    public function __construct(private AmenitiesRepository $repository,private PropertyRoomsWidgetAmenitiesRepository $propertyRoomsWidgetAmenitiesRepository)
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

    public function saveUpdateWidgetForPropertyAmenity(PropertyRoomsWidget $widget,$items): PropertyRoomsWidget
    {
        foreach ($items['amenityRoom'] as $item) {
            $amenity = $this->propertyRoomsWidgetAmenitiesRepository->findOneBy(['roomsWidget'=>$widget->getId(),'amenity'=>intval($item)]);
            if ($amenity == null){
                $roomsWidgetAmenity = new PropertyRoomsWidgetAmenities();
                $amenity = $this->repository->findOneBy(['id'=>$item]);
                if ($amenity){
                    $a= $roomsWidgetAmenity->setAmenity($amenity);
                    $widget->addPropertyRoomsWidgetAmenity($a);
                }
            }
        }
        return $widget;
    }
}