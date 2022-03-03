<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity()]
class SettingsTranslation implements TranslationInterface
{
    use TranslationTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'string', length: 255)]
    private $siteName;

    #[ORM\Column(type: 'string', length: 255)]
    private $metaKeywords;

    #[ORM\Column(type: 'text')]
    private $metaDescription;
    #[ORM\Column(type: 'text', nullable: true)]
    private $privacyPolicy;

    #[ORM\Column(type: 'text', nullable: true)]
    private $termsOfService;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteName(): ?string
    {
        return $this->siteName;
    }

    public function setSiteName(string $siteName): self
    {
        $this->siteName = $siteName;

        return $this;
    }

    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }

    public function setMetaKeywords(string $metaKeywords): self
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getPrivacyPolicy(): ?string
    {
        return $this->privacyPolicy;
    }

    public function setPrivacyPolicy(?string $privacyPolicy): self
    {
        $this->privacyPolicy = $privacyPolicy;

        return $this;
    }

    public function getTermsOfService(): ?string
    {
        return $this->termsOfService;
    }

    public function setTermsOfService(?string $termsOfService): self
    {
        $this->termsOfService = $termsOfService;

        return $this;
    }
}
