<?php

namespace App\Services\StableDiffusion\Interfaces;

interface HasSettingInterface
{
    public function addSetting(string $key, $value): self;
    public function loadSettingsFromArray(array $settings): self;

    public function removeSetting(string $key): self;

    public function enableSetting(string $key): self;
    public function disableSetting(string $key): self;

    public function getSettings(): array;

    public function getSettingsJson(): string;
}
