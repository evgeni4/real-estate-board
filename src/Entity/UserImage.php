<?php

namespace App\Entity;

use App\Repository\UserImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserImageRepository::class)]
#[ORM\Table(name: '`userImages`')]
class UserImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userImages')]
    private $user;

    #[ORM\Column(type: 'string', length: 255)]
    private $fileNameBig;

    #[ORM\Column(type: 'string', length: 255)]
    private $fileNameMiddle;

    #[ORM\Column(type: 'string', length: 255)]
    private $fileNameSmall;


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

    public function getFileNameBig(): ?string
    {
        return $this->fileNameBig;
    }

    public function setFileNameBig(string $fileNameBig): self
    {
        $this->fileNameBig = $fileNameBig;

        return $this;
    }

    public function getFileNameMiddle(): ?string
    {
        return $this->fileNameMiddle;
    }

    public function setFileNameMiddle(string $fileNameMiddle): self
    {
        $this->fileNameMiddle = $fileNameMiddle;

        return $this;
    }

    public function getFileNameSmall(): ?string
    {
        return $this->fileNameSmall;
    }

    public function setFileNameSmall(string $fileNameSmall): self
    {
        $this->fileNameSmall = $fileNameSmall;

        return $this;
    }



}
