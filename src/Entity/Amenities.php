<?php

namespace App\Entity;

use App\Repository\AmenitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AmenitiesRepository::class)]
class Amenities implements TranslatableInterface
{
    use TranslatableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'uuid', nullable: true)]
    private $uuid;
    #[ORM\Column(type: 'boolean')]
    private ?bool $published = true;

    #[ORM\OneToMany(mappedBy: 'amenity', targetEntity: PropertyAmenities::class,cascade: ['persist','remove'])]
    private $propertyAmenities;

    #[ORM\OneToMany(mappedBy: 'amenity', targetEntity: PropertyRoomsWidget::class,cascade: ['persist','remove'])]
    private $propertyRoomsWidgets;

    #[ORM\OneToMany(mappedBy: 'amenity', targetEntity: PropertyRoomsWidgetAmenities::class,cascade: ['persist','remove'])]
    private $propertyRoomsWidgetAmenities;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
        $this->propertyAmenities = new ArrayCollection();
        $this->propertyRoomsWidgets = new ArrayCollection();
        $this->propertyRoomsWidgetAmenities = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->translate($this->currentLocale)->getTitle();
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

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return Collection|PropertyAmenities[]
     */
    public function getPropertyAmenities(): Collection
    {
        return $this->propertyAmenities;
    }

    public function addPropertyAmenity(PropertyAmenities $propertyAmenity): self
    {
        if (!$this->propertyAmenities->contains($propertyAmenity)) {
            $this->propertyAmenities[] = $propertyAmenity;
            $propertyAmenity->setAmenity($this);
        }

        return $this;
    }

    public function removePropertyAmenity(PropertyAmenities $propertyAmenity): self
    {
        if ($this->propertyAmenities->removeElement($propertyAmenity)) {
            // set the owning side to null (unless already changed)
            if ($propertyAmenity->getAmenity() === $this) {
                $propertyAmenity->setAmenity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PropertyRoomsWidget[]
     */
    public function getPropertyRoomsWidgets(): Collection
    {
        return $this->propertyRoomsWidgets;
    }

    public function addPropertyRoomsWidget(PropertyRoomsWidget $propertyRoomsWidget): self
    {
        if (!$this->propertyRoomsWidgets->contains($propertyRoomsWidget)) {
            $this->propertyRoomsWidgets[] = $propertyRoomsWidget;
            $propertyRoomsWidget->setAmenity($this);
        }

        return $this;
    }

    public function removePropertyRoomsWidget(PropertyRoomsWidget $propertyRoomsWidget): self
    {
        if ($this->propertyRoomsWidgets->removeElement($propertyRoomsWidget)) {
            // set the owning side to null (unless already changed)
            if ($propertyRoomsWidget->getAmenity() === $this) {
                $propertyRoomsWidget->setAmenity(null);
            }
        }

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
            $propertyRoomsWidgetAmenity->setAmenity($this);
        }

        return $this;
    }

    public function removePropertyRoomsWidgetAmenity(PropertyRoomsWidgetAmenities $propertyRoomsWidgetAmenity): self
    {
        if ($this->propertyRoomsWidgetAmenities->removeElement($propertyRoomsWidgetAmenity)) {
            // set the owning side to null (unless already changed)
            if ($propertyRoomsWidgetAmenity->getAmenity() === $this) {
                $propertyRoomsWidgetAmenity->setAmenity(null);
            }
        }

        return $this;
    }

}
