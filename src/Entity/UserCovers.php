<?php

namespace App\Entity;

use App\Repository\UserCoversRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCoversRepository::class)]
class UserCovers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cover;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'cover')]
    private $userCover;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getUserCover(): ?User
    {
        return $this->userCover;
    }

    public function setUserCover(?User $userCover): self
    {
        $this->userCover = $userCover;

        return $this;
    }



}
