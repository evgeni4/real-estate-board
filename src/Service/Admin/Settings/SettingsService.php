<?php

namespace App\Service\Admin\Settings;

use App\Entity\Settings;
use App\Repository\SettingsRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class SettingsService implements SettingsServiceInterface
{
    public function __construct(
        private SettingsRepository $settingsRepository,
        private UrlGeneratorInterface $urlGenerator
    )
    {
    }

    public function add(Settings $settings): bool
    {
        return $this->settingsRepository->insert($settings);
    }

    public function update(Settings $settings): bool
    {
        return $this->settingsRepository->edit($settings);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneRecord(): ?Settings
    {
        return $this->settingsRepository->findOne();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function checkComing(): ?bool
    {
        $settings = $this->findOneRecord();
        $date = $settings->getComing()->format('d-m-Y H:i:s');
        $newDate = new \DateTime();
        $newDate = $newDate->format('d-m-Y H:i:s');
        if (strtotime($newDate) > strtotime($date)) {
            return true;
        }
        return null;
    }


}