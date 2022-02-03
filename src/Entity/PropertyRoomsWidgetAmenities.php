<?php

namespace App\Entity;

use App\Repository\PropertyRoomsWidgetAmenitiesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyRoomsWidgetAmenitiesRepository::class)]
#[ORM\Table(name: '`properties_rooms_widget_amenities`')]
class PropertyRoomsWidgetAmenities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: PropertyRoomsWidget::class, cascade: ['persist','remove'], inversedBy: 'propertyRoomsWidgetAmenities')]
    private $roomsWidget;

    #[ORM\ManyToOne(targetEntity: Amenities::class,cascade: ['persist','remove'], inversedBy: 'propertyRoomsWidgetAmenities')]
    private $amenity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomsWidget(): ?PropertyRoomsWidget
    {
        return $this->roomsWidget;
    }

    public function setRoomsWidget(?PropertyRoomsWidget $roomsWidget): self
    {
        $this->roomsWidget = $roomsWidget;

        return $this;
    }

    public function getAmenity(): ?Amenities
    {
        return $this->amenity;
    }

    public function setAmenity(?Amenities $amenity): self
    {
        $this->amenity = $amenity;

        return $this;
    }
}
