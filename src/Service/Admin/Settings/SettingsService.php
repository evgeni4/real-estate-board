<?php

namespace App\Service\Admin\Settings;

use App\Entity\Settings;
use App\Repository\SettingsRepository;
use Doctrine\ORM\NonUniqueResultException;

class SettingsService implements SettingsServiceInterface
{
    public function __construct(private SettingsRepository $settingsRepository)
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
}