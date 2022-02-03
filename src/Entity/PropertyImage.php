<?php

namespace App\Entity;

use App\Repository\PropertyImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyImageRepository::class)]
#[ORM\Table('`properties_images`')]
class PropertyImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $imageSm;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $imageMd;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $imageLg;

    #[ORM\ManyToOne(targetEntity: Property::class, inversedBy: 'propertyImages')]
    private $property;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageSm(): ?string
    {
        return $this->imageSm;
    }

    public function setImageSm(?string $imageSm): self
    {
        $this->imageSm = $imageSm;

        return $this;
    }

    public function getImageMd(): ?string
    {
        return $this->imageMd;
    }

    public function setImageMd(?string $imageMd): self
    {
        $this->imageMd = $imageMd;

        return $this;
    }

    public function getImageLg(): ?string
    {
        return $this->imageLg;
    }

    public function setImageLg(?string $imageLg): self
    {
        $this->imageLg = $imageLg;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
