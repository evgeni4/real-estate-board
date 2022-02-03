<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
#[ORM\Table(name: '`properties`')]
class Property implements TranslatableInterface
{
    use TranslatableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'uuid', nullable: true)]
    private $uuid;
    #[ORM\Column(type: 'decimal', precision: 10, scale: '0')]
    private ?string $price;

    #[ORM\Column(type: 'boolean')]
    private ?bool $published = false;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $area;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $bedrooms;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $bathrooms;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $accommodation;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $yardSize;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $garage;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'properties')]
    private ?User $agent;

    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'properties')]
    private ?Type $types;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'properties')]
    private ?Category $category;

    #[ORM\Column(type: 'text', length: 255, nullable: true)]
    private ?string $latitude;

    #[ORM\Column(type: 'text', length: 255, nullable: true)]
    private ?string $longitude;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $address;

    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'properties')]
    private $country;

    #[ORM\ManyToOne(targetEntity: State::class, inversedBy: 'properties')]
    private $state;

    #[ORM\ManyToOne(targetEntity: City::class, inversedBy: 'properties')]
    private $city;
    #[ORM\Column(type: "datetime")]
    private $createdAt;

    #[ORM\Column(type: 'bigint')]
    private $referenceNumber;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: PropertyAmenities::class, cascade: ['persist','remove'],orphanRemoval: true)]
    private $propertyAmenities;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: PropertyImage::class, cascade: ['persist','remove'] ,orphanRemoval: true)]
    private $propertyImages;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: PropertyRoomsWidget::class, cascade: ['persist','remove'] ,orphanRemoval: true)]
    private $propertyRoomsWidgets;

    #[ORM\Column(type: 'boolean')]
    private $roomWidgetStatus = false;

    #[ORM\OneToMany(mappedBy: 'propertyPlan', targetEntity: PropertyPlan::class, cascade: ['persist','remove'] ,orphanRemoval: true)]
    private $propertyPlans;

    #[ORM\Column(type: 'boolean')]
    private $propertyPlanStatus = false;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $video;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $videoPresentation;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $contactFormStatus;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $googleMapStatus;
    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->referenceNumber = abs( crc32( uniqid()));
        $this->uuid = Uuid::v4();
        $this->propertyAmenities = new ArrayCollection();
        $this->propertyImages = new ArrayCollection();
        $this->propertyRoomsWidgets = new ArrayCollection();
        $this->propertyPlans = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
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

    public function getArea(): ?float
    {
        return $this->area;
    }

    public function setArea(float $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getBathrooms(): ?int
    {
        return $this->bathrooms;
    }

    public function setBathrooms(int $bathrooms): self
    {
        $this->bathrooms = $bathrooms;

        return $this;
    }

    public function getAccommodation(): ?int
    {
        return $this->accommodation;
    }

    public function setAccommodation(?int $accommodation): self
    {
        $this->accommodation = $accommodation;

        return $this;
    }

    public function getYardSize(): ?int
    {
        return $this->yardSize;
    }

    public function setYardSize(?int $yardSize): self
    {
        $this->yardSize = $yardSize;

        return $this;
    }

    public function getGarage(): ?int
    {
        return $this->garage;
    }

    public function setGarage(?int $garage): self
    {
        $this->garage = $garage;

        return $this;
    }

    public function getAgent(): ?User
    {
        return $this->agent;
    }

    public function setAgent(?User $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getTypes(): ?Type
    {
        return $this->types;
    }

    public function setTypes(?Type $types): self
    {
        $this->types = $types;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getReferenceNumber(): ?string
    {
        return $this->referenceNumber;
    }

    public function setReferenceNumber(string $referenceNumber): self
    {
        $this->referenceNumber = $referenceNumber;

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
            $propertyAmenity->setProperty($this);
        }

        return $this;
    }

    public function removePropertyAmenity(PropertyAmenities $propertyAmenity): self
    {
        if ($this->propertyAmenities->removeElement($propertyAmenity)) {
            // set the owning side to null (unless already changed)
            if ($propertyAmenity->getProperty() === $this) {
                $propertyAmenity->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PropertyImage[]
     */
    public function getPropertyImages(): Collection
    {
        return $this->propertyImages;
    }

    public function addPropertyImage(PropertyImage $propertyImage): self
    {
        if (!$this->propertyImages->contains($propertyImage)) {
            $this->propertyImages[] = $propertyImage;
            $propertyImage->setProperty($this);
        }

        return $this;
    }

    public function removePropertyImage(PropertyImage $propertyImage): self
    {
        if ($this->propertyImages->removeElement($propertyImage)) {
            // set the owning side to null (unless already changed)
            if ($propertyImage->getProperty() === $this) {
                $propertyImage->setProperty(null);
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
            $propertyRoomsWidget->setProperty($this);
        }

        return $this;
    }

    public function removePropertyRoomsWidget(PropertyRoomsWidget $propertyRoomsWidget): self
    {
        if ($this->propertyRoomsWidgets->removeElement($propertyRoomsWidget)) {
            // set the owning side to null (unless already changed)
            if ($propertyRoomsWidget->getProperty() === $this) {
                $propertyRoomsWidget->setProperty(null);
            }
        }

        return $this;
    }

    public function getRoomWidgetStatus(): ?bool
    {
        return $this->roomWidgetStatus;
    }

    public function setRoomWidgetStatus(bool $roomWidgetStatus): self
    {
        $this->roomWidgetStatus = $roomWidgetStatus;

        return $this;
    }

    /**
     * @return Collection|PropertyPlan[]
     */
    public function getPropertyPlans(): Collection
    {
        return $this->propertyPlans;
    }

    public function addPropertyPlan(PropertyPlan $propertyPlan): self
    {
        if (!$this->propertyPlans->contains($propertyPlan)) {
            $this->propertyPlans[] = $propertyPlan;
            $propertyPlan->setPropertyPlan($this);
        }

        return $this;
    }

    public function removePropertyPlan(PropertyPlan $propertyPlan): self
    {
        if ($this->propertyPlans->removeElement($propertyPlan)) {
            // set the owning side to null (unless already changed)
            if ($propertyPlan->getPropertyPlan() === $this) {
                $propertyPlan->setPropertyPlan(null);
            }
        }

        return $this;
    }

    public function getPropertyPlanStatus(): ?bool
    {
        return $this->propertyPlanStatus;
    }

    public function setPropertyPlanStatus(bool $propertyPlanStatus): self
    {
        $this->propertyPlanStatus = $propertyPlanStatus;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getVideoPresentation(): ?bool
    {
        return $this->videoPresentation;
    }

    public function setVideoPresentation(?bool $videoPresentation): self
    {
        $this->videoPresentation = $videoPresentation;

        return $this;
    }

    public function getContactFormStatus(): ?bool
    {
        return $this->contactFormStatus;
    }

    public function setContactFormStatus(?bool $contactFormStatus): self
    {
        $this->contactFormStatus = $contactFormStatus;

        return $this;
    }

    public function getGoogleMapStatus(): ?bool
    {
        return $this->googleMapStatus;
    }

    public function setGoogleMapStatus(?bool $googleMapStatus): self
    {
        $this->googleMapStatus = $googleMapStatus;

        return $this;
    }





}
