<?php

namespace App\Service\Manager\PropertyManager;

use App\Entity\Amenities;
use App\Entity\Property;
use App\Entity\PropertyAmenities;
use App\Repository\PropertyRoomsWidgetRepository;
use App\Service\File\FileSaver;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class PropertyManager
{
    public function __construct(
        private FileSaver             $fileSaver,
        private PropertyManagerHelper $propertyManagerHelper,
        private PropertyRoomsWidgetRepository $propertyRoomsWidgetRepository
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

    public function updatePropertyAmenity(Property $property, Form $form): Property
    {
        $amenities = $form['amenity']->getData();
        foreach ($amenities as $item) {
            $this->propertyManagerHelper->updateAddPropertyAmenity($property, $item);
        }
        return $property;
    }



    public function addPropertyImages(Property $property, Form $form): Property
    {
        $imageFiles = $form->get('images')->getData();
        $dirImage = uniqid();
        $dirImage = $property->getPropertyImages()->getValues() ? $property->getPropertyImages()->getValues()[0]->getSlug() : $dirImage;
        foreach ($imageFiles as $item) {
            $tempImageFileName = $item ? $this->fileSaver->saveUploadedPropertyFileIntoTemp($item) : null;
            $this->propertyManagerHelper->updatePropertyImage($property, $dirImage, $tempImageFileName);
        }
        return $property;
    }

    public function addPropertyWidget(Property $property, Form $form, Request $request): Property
    {
        if (array_key_exists('propertyRoomsWidgets', (array)$request->request->get('property_form'))) {

            $widgets = $form['propertyRoomsWidgets']->getData();
            $amenities = $request->request->get('property_form')['propertyRoomsWidgets'];
            // dd($widgets);
            foreach ($widgets as $key => $widget) {
                $this->propertyManagerHelper->savePropertyAmenityWidget($property, $widget, $amenities[$key]);
                $imageFile = $request->files->get('property_form')['propertyRoomsWidgets'][$key]['imageRoom'];
                $dirImage = uniqid();
                $tempImageFileName = $imageFile ? $this->fileSaver->saveUploadedPropertyWidgetFileIntoTemp($imageFile) : null;

                $this->propertyManagerHelper->updatePropertyWidgetImage($property, $widget, $dirImage, $tempImageFileName);
                $property->addPropertyRoomsWidget($widget);
            }
            return $property;
        }
        return $property;
    }
    public function updatePropertyWidget(Property $property, Form $form, Request $request): Property
    {
        if (array_key_exists('propertyRoomsWidgets', (array)$request->request->get('property_form'))) {

            $widgets = $form['propertyRoomsWidgets']->getData();
            $amenities = $request->request->get('property_form')['propertyRoomsWidgets'];
            foreach ($widgets as $key => $widget) {
                $this->propertyManagerHelper->saveUpdatePropertyAmenityWidget($property, $widget, $amenities[$key]);

                $imageFile = $request->files->get('property_form')['propertyRoomsWidgets'][$key]['imageRoom'];
                $dirImage =$widget->getSlug()? $widget->getSlug(): uniqid();
                $tempImageFileName = $imageFile ? $this->fileSaver->saveUploadedPropertyWidgetFileIntoTemp($imageFile) : null;
//
                $this->propertyManagerHelper->updatePropertyWidgetImage($property, $widget, $dirImage, $tempImageFileName);
                $property->addPropertyRoomsWidget($widget);
            }
            return $property;
        }
        return $property;
    }
    public function addPropertyPlan(Property $property, Form $form, Request $request): Property
    {
        if (array_key_exists('propertyPlans', (array)$request->request->get('property_form'))) {
            $plans = $form['propertyPlans']->getData();

            foreach ($plans as $key => $plan) {
                $imageFile = $request->files->get('property_form')['propertyPlans'][$key]['imagePlan'];
                $dirImage =$plan->getSlug()? $plan->getSlug(): uniqid();
                $tempImageFileName = $imageFile ? $this->fileSaver->saveUploadedPropertyPlanFileIntoTemp($imageFile) : null;
                $this->propertyManagerHelper->updatePropertyPlanImage($property, $plan, $dirImage, $tempImageFileName);
            }
            return $property;
        }
        return $property;
    }

}