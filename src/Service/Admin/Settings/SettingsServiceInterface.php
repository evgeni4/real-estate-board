<?php

namespace App\Service\Admin\Settings;

use App\Entity\Settings;

interface SettingsServiceInterface
{
    public function add(Settings $settings): bool;

    public function update(Settings $settings): bool;

    public function findOneRecord(): ?Settings;
}