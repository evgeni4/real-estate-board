<?php

namespace App\Service\Admin\Settings;

use App\Entity\Settings;
use App\Repository\SettingsRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
class SettingsService implements SettingsServiceInterface
{
    private UrlGeneratorInterface $urlGenerator;
    private SettingsRepository $settingsRepository;

    public function __construct(
       SettingsRepository    $settingsRepository,
       UrlGeneratorInterface $urlGenerator
    )
    {
        $this->settingsRepository=$settingsRepository;
        $this->urlGenerator = $urlGenerator;
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
        return false;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function closeSite(): bool|RedirectResponse
    {
        if (!$this->checkComing()) {
            return new RedirectResponse('/');
        }
        return false;
    }

}