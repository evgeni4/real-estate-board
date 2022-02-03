<?php

namespace App\Service\Manager\PropertyManager;

use App\Entity\Property;
use App\Entity\PropertyAmenities;
use App\Service\File\FileSaver;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class PropertyManager
{
    public function __construct(
        private FileSaver             $fileSaver,
        private ContainerInterface    $container,
        private PropertyManagerHelper $propertyManagerHelper
    )
    {
    }

    public function addPropertyAmenity(Property $property, Form $form): Property
    {
        $amenities = $form['amenity']->getData();
        foreach ($amenities as $item) {
            $this->propertyManagerHelper->savePropertyAmenity($property, $item);
        }
        return $property;
    }

    public function addPropertyImages(Property $property, Form $form): Property
    {
        $imageFiles = $form->get('images')->getData();
        $dirImage = uniqid();
        foreach ($imageFiles as $item) {
            $tempImageFileName = $item ? $this->fileSaver->saveUploadedPropertyFileIntoTemp($item) : null;
            $this->propertyManagerHelper->updatePropertyImage($property, $dirImage, $tempImageFileName);
        }
        return $property;
    }
}