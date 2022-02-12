<?php

namespace App\Service\Manager\PropertyManager;

use App\Entity\Amenities;
use App\Entity\PropertyAmenities;

class PropertyAmenityManager
{

    public function saveAmenityForProperty($item): PropertyAmenities
    {
        $amenityProperty = new PropertyAmenities();
        $amenityProperty->setChecked(true);
        $amenityProperty->setAmenity($item);
        return $amenityProperty;
    }
}