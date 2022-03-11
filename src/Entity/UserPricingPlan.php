<?php

namespace App\Entity;

use App\Repository\UserPricingPlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPricingPlanRepository::class)]
class UserPricingPlan
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userPricingPlans')]
    private $user;

    #[ORM\ManyToOne(targetEntity: PricingPlan::class, inversedBy: 'userPricingPlans')]
    private $pricingPlan;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTime $validDate;

    public function __construct()
    {
        $this->createdAt=new \DateTimeImmutable();
        $this->validDate=new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPricingPlan(): ?PricingPlan
    {
        return $this->pricingPlan;
    }

    public function setPricingPlan(?PricingPlan $pricingPlan): self
    {
        $this->pricingPlan = $pricingPlan;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getValidDate(): ?\DateTime
    {
        return $this->validDate;
    }

    public function setValidDate(?\DateTime $validDate): self
    {
        $this->validDate = $validDate;

        return $this;
    }
}
