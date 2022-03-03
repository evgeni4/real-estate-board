<?php

namespace App\Service\Admin\Settings;

use App\Entity\Settings;
use Symfony\Component\HttpFoundation\RedirectResponse;

interface SettingsServiceInterface
{
    public function add(Settings $settings): bool;

    public function update(Settings $settings): bool;

    public function findOneRecord(): ?Settings;

    public function checkComing():?bool;
}