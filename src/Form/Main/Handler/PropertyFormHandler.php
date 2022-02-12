<?php

namespace App\Form\Main\Handler;

use App\Entity\Amenities;
use App\Entity\Property;
use App\Entity\PropertyAmenities;
use App\Service\Manager\PropertyManager\PropertyManager;
use App\Service\Property\PropertyServiceInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class PropertyFormHandler
{
    public function __construct(
        private PropertyServiceInterface $propertyService,
        private UserServiceInterface     $userService,
        private PropertyManager          $propertyManager,
    )
    {
    }

    public function processAddPropertyForm(Property $property, Form $form, Request $request): Property
    {
        $user = $this->userService->currentUser();
        $property->setAgent($user);
        $this->propertyManager->addPropertyImages($property, $form);
        $this->propertyManager->addPropertyAmenity($property, $form);
        $this->propertyManager->addPropertyWidget($property, $form,$request);
        $this->propertyManager->addPropertyPlan($property, $form,$request);
        $this->propertyService->add($property);
        return $property;
    }

    public function processUpdatePropertyForm(Property $property,Form $form , Request $request): Property
    {
        $this->propertyManager->addPropertyImages($property, $form);
        $this->propertyManager->updatePropertyAmenity($property, $form);
        $this->propertyManager->updatePropertyWidget($property, $form,$request);
        $this->propertyManager->addPropertyPlan($property, $form,$request);
        $this->propertyService->edit($property);
        return $property;
    }
}