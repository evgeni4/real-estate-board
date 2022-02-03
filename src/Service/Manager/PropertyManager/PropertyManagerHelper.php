<?php

namespace App\Service\Manager\PropertyManager;

use App\Entity\Amenities;
use App\Entity\Property;
use App\Entity\PropertyAmenities;
use App\Service\File\FileSaver;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PropertyManagerHelper
{
    public function __construct(
        private ContainerInterface     $serviceContainer,
        private PropertyImageManager   $propertyImageManager,
        private PropertyAmenityManager $amenityManager
    )
    {
    }

    public function getPropertyImageDir($dirImage): string
    {
        $propertyImageDir = $this->serviceContainer->getParameter('uploads_property');
        return sprintf('%s-%s', $propertyImageDir, $dirImage);
    }

    public function updatePropertyImage(Property $property, string $dirImage, string $tempImageFileName = null): Property
    {
        if (!$tempImageFileName) {
            return $property;
        }
        $propertyDir = $this->getPropertyImageDir($dirImage);
        $propertyImage = $this->propertyImageManager->saveImageForProperty($propertyDir, $tempImageFileName);
        $propertyImage->setSlug($dirImage);
        $propertyImage->setProperty($property);
        $property->addPropertyImage($propertyImage);
        return $property;
    }

    public function savePropertyAmenity(Property $property, $item): Property
    {
        $propertyAmenity = $this->amenityManager->saveAmenityForProperty($item);
        $property->addPropertyAmenity($propertyAmenity);
        return $property;
    }
}