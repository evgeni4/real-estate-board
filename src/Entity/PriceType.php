<?php

namespace App\Entity;

use App\Repository\PriceTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

#[ORM\Entity(repositoryClass: PriceTypeRepository::class)]
#[ORM\Table(name: 'prices_types')]
class PriceType implements TranslatableInterface
{
    use TranslatableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'priceTypes')]
    private $type;

    #[ORM\OneToMany(mappedBy: 'period', targetEntity: Property::class, cascade: ['persist','remove'])]
    private $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->translate($this->currentLocale)->getTitle();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Property[]
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->setPeriod($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getPeriod() === $this) {
                $property->setPeriod(null);
            }
        }

        return $this;
    }
}
