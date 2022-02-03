<?php

namespace App\Entity;

use App\Repository\PropertyPlanRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

#[ORM\Entity(repositoryClass: PropertyPlanRepository::class)]
#[ORM\Table(name: "`properties_plan`")]
class PropertyPlan implements TranslatableInterface
{
    use TranslatableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $area;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $published;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $imagePlan;

    #[ORM\ManyToOne(targetEntity: Property::class, cascade: ['persist','remove'], inversedBy: 'propertyPlans')]
    private $propertyPlan;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(?int $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(?bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getImagePlan(): ?string
    {
        return $this->imagePlan;
    }

    public function setImagePlan(?string $imagePlan): self
    {
        $this->imagePlan = $imagePlan;

        return $this;
    }

    public function getPropertyPlan(): ?Property
    {
        return $this->propertyPlan;
    }

    public function setPropertyPlan(?Property $propertyPlan): self
    {
        $this->propertyPlan = $propertyPlan;

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
