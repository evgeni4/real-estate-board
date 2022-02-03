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

    public function addPropertyWidget(Property $property, Form $form, Request $request): Property
    {
        if (array_key_exists('roomWidget', (array)$request->request->get('property_form'))) {
            $widgets = $form['roomWidget']->getData();
            $amenities = $request->request->get('property_form')['roomWidget'];
            // dd($widgets);
            foreach ($widgets as $key => $widget) {
                $this->propertyManagerHelper->savePropertyAmenityWidget($property, $widget, $amenities[$key]);
                $imageFile = $request->files->get('property_form')['roomWidget'][$key]['imageRoom'];
                $dirImage = uniqid();
                $tempImageFileName = $imageFile ? $this->fileSaver->saveUploadedPropertyWidgetFileIntoTemp($imageFile) : null;

                $this->propertyManagerHelper->updatePropertyWidgetImage($property, $widget, $dirImage, $tempImageFileName);
                $property->addPropertyRoomsWidget($widget);
            }
            return $property;
        }
        return $property;
    }

    public function addPropertyPlan(Property $property, Form $form, Request $request): Property
    {
        if (array_key_exists('propertyPlan', (array)$request->request->get('property_form'))) {
            $plans = $form['propertyPlan']->getData();
            foreach ($plans as $key=>$plan) {
                $imageFile = $request->files->get('property_form')['propertyPlan'][$key]['imagePlan'];
                $dirImage = uniqid();
                $tempImageFileName = $imageFile ? $this->fileSaver->saveUploadedPropertyPlanFileIntoTemp($imageFile) : null;
                $this->propertyManagerHelper->updatePropertyPlanImage($property, $plan, $dirImage, $tempImageFileName);
            }
            return $property;
        }
        return $property;
    }

}