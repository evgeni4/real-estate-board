<?php

namespace App\Entity;

use App\Repository\PropertyRoomsWidgetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

#[ORM\Entity(repositoryClass: PropertyRoomsWidgetRepository::class)]
#[ORM\Table(name: "`properties_rooms_widgets`")]
class PropertyRoomsWidget  implements TranslatableInterface
{
    use TranslatableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'boolean')]
    private bool $published ;
//amenity
    #[ORM\ManyToOne(targetEntity: Property::class, cascade: ['persist','remove'], inversedBy: 'propertyRoomsWidgets')]
    private $property;

    #[ORM\OneToMany(mappedBy: 'roomsWidget', targetEntity: PropertyRoomsWidgetAmenities::class,cascade: ['persist','remove'])]
    private $propertyRoomsWidgetAmenities;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $imageRoom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $slug;

    public function __construct()
    {
        $this->propertyRoomsWidgetAmenities = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
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

    /**
     * @return Collection|PropertyRoomsWidgetAmenities[]
     */
    public function getPropertyRoomsWidgetAmenities(): Collection
    {
        return $this->propertyRoomsWidgetAmenities;
    }

    public function addPropertyRoomsWidgetAmenity(PropertyRoomsWidgetAmenities $propertyRoomsWidgetAmenity): self
    {
        if (!$this->propertyRoomsWidgetAmenities->contains($propertyRoomsWidgetAmenity)) {
            $this->propertyRoomsWidgetAmenities[] = $propertyRoomsWidgetAmenity;
            $propertyRoomsWidgetAmenity->setRoomsWidget($this);
        }

        return $this;
    }

    public function removePropertyRoomsWidgetAmenity(PropertyRoomsWidgetAmenities $propertyRoomsWidgetAmenity): self
    {
        if ($this->propertyRoomsWidgetAmenities->removeElement($propertyRoomsWidgetAmenity)) {
            // set the owning side to null (unless already changed)
            if ($propertyRoomsWidgetAmenity->getRoomsWidget() === $this) {
                $propertyRoomsWidgetAmenity->setRoomsWidget(null);
            }
        }

        return $this;
    }

    public function getImageRoom(): ?string
    {
        return $this->imageRoom;
    }

    public function setImageRoom(?string $imageRoom): self
    {
        $this->imageRoom = $imageRoom;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

}
