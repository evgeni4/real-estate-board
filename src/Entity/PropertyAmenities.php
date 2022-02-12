<?php

namespace App\Entity;

use App\Repository\PropertyAmenitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyAmenitiesRepository::class)]
#[ORM\Table(name: '`properties_amenities`')]
class PropertyAmenities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\ManyToOne(targetEntity: Property::class, cascade: ['persist', 'remove'], inversedBy: 'propertyAmenities')]
    private $property;

    #[ORM\ManyToOne(targetEntity: Amenities::class, cascade: ['persist', 'remove'], inversedBy: 'propertyAmenities')]
    private ?Amenities $amenity;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $checked;

    public function __construct()
    {
        $this->checked= true;
    }

//amenity
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

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

    public function getChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(bool $checked): self
    {
        $this->checked = $checked;

        return $this;
    }


}
