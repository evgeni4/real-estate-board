<?php

namespace App\Service\Manager\PropertyManager;

use App\Entity\Amenities;
use App\Entity\Property;
use App\Entity\PropertyAmenities;
use App\Entity\PropertyImage;
use App\Entity\PropertyPlan;
use App\Entity\PropertyRoomsWidget;
use App\Repository\AmenitiesRepository;
use App\Repository\PropertyAmenitiesRepository;
use App\Service\File\FileSaver;
use App\Service\File\FileSystem\FileSystemWorker;
use App\Service\Property\PropertyServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PropertyManagerHelper
{
    public function __construct(
        private ContainerInterface       $serviceContainer,
        private PropertyImageManager     $propertyImageManager,
        private PropertyAmenityManager   $amenityManager,
        private PropertyWidgetManager    $widgetManager,
        private FileSystemWorker         $fileSystemWorker,
        private PropertyServiceInterface $propertyService,
        private EntityManagerInterface           $entityManager
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

    public function updateAddPropertyAmenity(Property $property, $item): Property
    {
        $data = $this->propertyService->findOneByProductAmenities($property, $item->getId());
        if ($data == null) {
            $propertyAmenity = $this->amenityManager->saveAmenityForProperty($item);
            $property->addPropertyAmenity($propertyAmenity);
            return $property;
        }
        return $property;
    }

    public function updateCheckedPropertyAmenity($ids, Property $property): bool
    {
        $data = $this->propertyService->findOneByProductAmenities($property, $ids);
        if ($data != null && $data->getChecked() == 0) {
            $data->getProperty()->addPropertyAmenity($data->setChecked(true));
            return true;
        } elseif ($data != null && $data->getChecked() == 1) {
            $data->getProperty()->addPropertyAmenity($data->setChecked(false));
            return true;
        }
        return true;
    }

    public function savePropertyAmenityWidget(Property $property, $widget, $amenities): Property
    {
        if (array_key_exists('amenityRoom', $amenities)) {
            $widgetRoom = $this->widgetManager->saveWidgetForPropertyAmenity($widget, $amenities);
            $property->addPropertyRoomsWidget($widgetRoom);
            return $property;
        }
        return $property;
    }

    public function saveUpdatePropertyAmenityWidget(Property $property, $widget, $amenities): Property
    {
        if (array_key_exists('amenityRoom', $amenities)) {
            $widgetRoom = $this->widgetManager->saveUpdateWidgetForPropertyAmenity($widget, $amenities);
            $property->addPropertyRoomsWidget($widgetRoom);
            return $property;
        }
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
        return $widget;

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
        return $property;
    }

    /**
     * @param PropertyImage $propertyImage
     * @param string $propertyImageDir
     * @return void
     */
    public function removeImageFromProperty(PropertyImage $propertyImage, string $propertyImageDir)
    {
        $smallFilePath = $propertyImageDir . '/' . $propertyImage->getImageSm();
        $this->fileSystemWorker->remove($smallFilePath);
        $middleFilePath = $propertyImageDir . '/' . $propertyImage->getImageMd();
        $this->fileSystemWorker->remove($middleFilePath);
        $largeFilePath = $propertyImageDir . '/' . $propertyImage->getImageLg();
        $this->fileSystemWorker->remove($largeFilePath);
        $property = $propertyImage->getProperty();
        $property->removePropertyImage($propertyImage);
        $this->entityManager->flush();
    }

    public function removeImageFromPropertyWidget(PropertyRoomsWidget $propertyRoomsWidget, string $propertyWidgetImageDir)
    {
        $smallFilePath = $propertyWidgetImageDir;
        $this->fileSystemWorker->remove($smallFilePath);
        $property = $propertyRoomsWidget->getProperty();
        $amenities = $propertyRoomsWidget->getPropertyRoomsWidgetAmenities()->getValues();
        foreach ($amenities as $amenity) {
            $amenity->getAmenity()->removePropertyRoomsWidgetAmenity($amenity);
            $propertyRoomsWidget->removePropertyRoomsWidgetAmenity($amenity);
        }
        $property->removePropertyRoomsWidget($propertyRoomsWidget);
        $this->entityManager->flush();
    }

    public function removePropertyPlan(PropertyPlan $propertyPlan, ?Property $property,$propertyPlanImageDir)
    {
        $smallFilePath = $propertyPlanImageDir;

        $this->fileSystemWorker->remove($smallFilePath);
        $property->removePropertyPlan($propertyPlan);
        $this->entityManager->flush();
    }

}