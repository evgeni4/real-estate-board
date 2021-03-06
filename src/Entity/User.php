<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(fields={"email"}, message="alreadyUsed.label")
 * @UniqueEntity(fields={"phone"}, message="alreadyUsedPhone.label")
 * @UniqueEntity(fields={"otherPhone"}, message="alreadyUsedPhone.label")
 * @UniqueEntity(fields={"fax"}, message="alreadyUsedPhone.fax.label")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`users`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private $uuid;
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private ?string $email;

    #[ORM\Column(type: 'json')]
    private array $roles = ['ROLE_USER'];

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'boolean')]
    private bool $isBanned = false;

    #[ORM\Column(type:"boolean")]
    private bool $isVerified = false;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $facebookId;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $firstName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lastName;

    #[ORM\Column(type: 'text', nullable: true)]
    private $AboutMe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Agency;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserImage::class, cascade: ['persist','remove'] ,orphanRemoval: true)]
    private $userImages;

    #[ORM\OneToMany(mappedBy: 'userCover', targetEntity: UserCovers::class, cascade: ['persist','remove'] ,orphanRemoval: true)]

    private $cover;
    
    #[ORM\Column(type:"datetime")]

    private  $createdAt;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Reviews::class)]
    private $reviews;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Reviews::class)]
    private $authorReview;

    #[ORM\Column(type: 'string', length: 100,unique: true, nullable: true)]
    private $phone;

    #[ORM\Column(type: 'string', length: 100, unique: true, nullable: true)]
    private $otherPhone;

    #[ORM\Column(type: 'string', length: 100, unique: true, nullable: true)]
    private $fax;

    #[ORM\OneToMany(mappedBy: 'agent', targetEntity: Property::class, cascade: ['persist','remove'] ,orphanRemoval: true)]
    private $properties;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserPricingPlan::class)]
    private $userPricingPlans;

    public function __construct()
    {
        $this->createdAt=new \DateTime('now');
        $this->userImages = new ArrayCollection();
        $this->cover = new ArrayCollection();
        $this->uuid = Uuid::v4();
        $this->reviews = new ArrayCollection();
        $this->authorReview = new ArrayCollection();
        $this->properties = new ArrayCollection();
        $this->userPricingPlans = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getIsBanned(): ?bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(bool $isBanned): self
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    public function setFacebookId(?string $facebookId): self
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAboutMe(): ?string
    {
        return $this->AboutMe;
    }

    public function setAboutMe(?string $AboutMe): self
    {
        $this->AboutMe = $AboutMe;

        return $this;
    }

    public function getAgency(): ?string
    {
        return $this->Agency;
    }

    public function setAgency(?string $Agency): self
    {
        $this->Agency = $Agency;

        return $this;
    }

    /**
     * @return Collection|UserImage[]
     */
    public function getUserImages(): Collection
    {
        return $this->userImages;
    }

    public function addUserImage(UserImage $userImage): self
    {
        if (!$this->userImages->contains($userImage)) {
            $this->userImages[] = $userImage;
            $userImage->setUser($this);
        }

        return $this;
    }

    public function removeUserImage(UserImage $userImage): self
    {
        if ($this->userImages->removeElement($userImage)) {
            // set the owning side to null (unless already changed)
            if ($userImage->getUser() === $this) {
                $userImage->setUser(null);
            }
        }

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

    /**
     * @return Collection|UserCovers[]
     */
    public function getCover(): Collection
    {
        return $this->cover;
    }

    public function addCover(UserCovers $cover): self
    {
        if (!$this->cover->contains($cover)) {
            $this->cover[] = $cover;
            $cover->setUserCover($this);
        }

        return $this;
    }

    public function removeCover(UserCovers $cover): self
    {
        if ($this->cover->removeElement($cover)) {
            // set the owning side to null (unless already changed)
            if ($cover->getUserCover() === $this) {
                $cover->setUserCover(null);
            }
        }

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
     * @return Collection|Reviews[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setUser($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUser() === $this) {
                $review->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reviews[]
     */
    public function getAuthorReview(): Collection
    {
        return $this->authorReview;
    }

    public function addAuthorReview(Reviews $authorReview): self
    {
        if (!$this->authorReview->contains($authorReview)) {
            $this->authorReview[] = $authorReview;
            $authorReview->setAuthor($this);
        }

        return $this;
    }

    public function removeAuthorReview(Reviews $authorReview): self
    {
        if ($this->authorReview->removeElement($authorReview)) {
            // set the owning side to null (unless already changed)
            if ($authorReview->getAuthor() === $this) {
                $authorReview->setAuthor(null);
            }
        }

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getOtherPhone(): ?string
    {
        return $this->otherPhone;
    }

    public function setOtherPhone(?string $otherPhone): self
    {
        $this->otherPhone = $otherPhone;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

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
            $property->setAgent($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getAgent() === $this) {
                $property->setAgent(null);
            }
        }

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
            $userPricingPlan->setUser($this);
        }

        return $this;
    }

    public function removeUserPricingPlan(UserPricingPlan $userPricingPlan): self
    {
        if ($this->userPricingPlans->removeElement($userPricingPlan)) {
            // set the owning side to null (unless already changed)
            if ($userPricingPlan->getUser() === $this) {
                $userPricingPlan->setUser(null);
            }
        }

        return $this;
    }













}
