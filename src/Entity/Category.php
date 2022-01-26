<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'categories')]
class Category implements TranslatableInterface
{
    use TranslatableTrait;
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private ?bool $published = true;

    #[ORM\ManyToOne(targetEntity: Category::class,  cascade: ['persist'], inversedBy: 'category')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Category $parent;

    public function __toString(): string
    {
        return (string)$this->translate($this->currentLocale)->getTitle();
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
