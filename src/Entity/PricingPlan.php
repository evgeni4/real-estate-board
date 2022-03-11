<?php

namespace App\Entity;

use App\Repository\PricingPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PricingPlanRepository::class)]
class PricingPlan implements TranslatableInterface
{
    use TranslatableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private int $price = 0;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $listingCount = 1;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $days = 1;

    #[ORM\Column(type: 'boolean')]
    private ?bool $recommended = false;

    #[ORM\Column(type: 'integer')]
    private ?int $countImage = 3;

    #[ORM\Column(type: 'boolean')]
    private ?bool $published = true;
    #[ORM\Column(type: 'uuid', nullable: true)]
    private $uuid;

    #[ORM\OneToMany(mappedBy: 'pricingPlan', targetEntity: UserPricingPlan::class)]
    private $userPricingPlans;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
        $this->userPricingPlans = new ArrayCollection();
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
     * @return Collection<int, UserPricingPlan>
     */
    public function getUserPricingPlans(): Collection
    {
        return $this->userPricingPlans;
    }

    public function addUserPricingPlan(UserPricingPlan $userPricingPlan): self
    {
        if (!$this->userPricingPlans->contains($userPricingPlan)) {
            $this->userPricingPlans[] = $userPricingPlan;
            $userPricingPlan->setPricingPlan($this);
        }

        return $this;
    }

    public function removeUserPricingPlan(UserPricingPlan $userPricingPlan): self
    {
        if ($this->userPricingPlans->removeElement($userPricingPlan)) {
            // set the owning side to null (unless already changed)
            if ($userPricingPlan->getPricingPlan() === $this) {
                $userPricingPlan->setPricingPlan(null);
            }
        }

        return $this;
    }
}
