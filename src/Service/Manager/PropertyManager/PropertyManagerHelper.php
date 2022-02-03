<?php

namespace App\Service\Manager\PropertyManager;

use App\Entity\Amenities;
use App\Entity\Property;
use App\Entity\PropertyAmenities;
use App\Entity\PropertyPlan;
use App\Entity\PropertyRoomsWidget;
use App\Service\File\FileSaver;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PropertyManagerHelper
{
    public function __construct(
        private ContainerInterface     $serviceContainer,
        private PropertyImageManager   $propertyImageManager,
        private PropertyAmenityManager $amenityManager,
        private PropertyWidgetManager  $widgetManager
    )
    {
    }

    public function getPropertyImageDir($dirImage): string
    {
        $propertyImageDir = $this->serviceContainer->getParameter('uploads_property');
        return sprintf('%s-%s', $propertyImageDir, $dirImage);
    }
    public function getPropertyWidgetImageDir($dirImage): string
    {
        $propertyImageDir = $this->serviceContainer->getParameter('uploads_widget_property');
        return sprintf('%s-%s', $propertyImageDir, $dirImage);
    }
    public function getPropertyPlanImageDir($dirImage): string
    {
        $propertyImageDir = $this->serviceContainer->getParameter('uploads_plan_property');
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

    public function savePropertyAmenityWidget(Property $property, $widget, $amenities): Property
    {
        $widgetRoom = $this->widgetManager->saveWidgetForPropertyAmenity($widget, $amenities);
        $property->addPropertyRoomsWidget($widgetRoom);
        return $property;
    }

    public function updatePropertyWidgetImage(Property $property, PropertyRoomsWidget $widget, string $dirImage, ?string $tempImageFileName): Property|PropertyRoomsWidget
    {
        if (!$tempImageFileName) {
            return $property;
        }
        $propertyWidgetDir = $this->getPropertyWidgetImageDir($dirImage);
        $propertyWidgetImage = $this->propertyImageManager->saveImageForPropertyWidget($propertyWidgetDir, $tempImageFileName);
        $widget->setSlug($dirImage);
        $widget->setImageRoom($propertyWidgetImage);
        return  $widget;

    }

    public function updatePropertyPlanImage(Property $property, PropertyPlan $plan, string $dirImage, ?string $tempImageFileName): Property
    {
        if (!$tempImageFileName) {
            return $property;
        }
        $propertyPlanDir = $this->getPropertyPlanImageDir($dirImage);
        $propertyPlanImage = $this->propertyImageManager->saveImageForPropertyPlan($propertyPlanDir, $tempImageFileName);
        $plan->setSlug($dirImage);
        $plan->setImagePlan($propertyPlanImage);
        $property->addPropertyPlan($plan);
        return  $property;
    }
}