<?php

namespace App\Entity;

use App\Repository\PricingPlanRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

#[ORM\Entity(repositoryClass: PricingPlanRepository::class)]
class PricingPlan  implements TranslatableInterface
{
    use TranslatableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private int $price = 0;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $listingCount =1;

    #[ORM\Column(type: 'integer', nullable: true)]
    private  int $days =1;

    #[ORM\Column(type: 'boolean')]
    private ?bool $recommended = false;

    #[ORM\Column(type: 'integer')]
    private ?int $countImage = 3;

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
    public function getListingCount(): ?int
    {
        return $this->listingCount;
    }

    public function setListingCount(?int $listingCount): self
    {
        $this->listingCount = $listingCount;

        return $this;
    }

    public function getDays(): ?int
    {
        return $this->days;
    }

    public function setDays(?int $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getRecommended(): ?bool
    {
        return $this->recommended;
    }

    public function setRecommended(bool $recommended): self
    {
        $this->recommended = $recommended;

        return $this;
    }

    public function getCountImage(): ?int
    {
        return $this->countImage;
    }

    public function setCountImage(int $countImage): self
    {
        $this->countImage = $countImage;

        return $this;
    }
}
