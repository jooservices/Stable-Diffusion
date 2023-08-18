<?php

namespace App\Services\StableDiffusion\Settings;

class BaseSetting implements SettingInterface
{
    protected array $settings = [];

    public function set(string $key, mixed $value): SettingInterface
    {
        $this->settings[$key] = $value;

        return $this;
    }

    public function get(string $key): mixed
    {
        return $this->settings[$key];
    }

    public function toArray(): array
    {
        return $this->settings;
    }

    public function toJson(): string
    {
        return json_encode($this->settings);
    }

    public function enable(string $key): SettingInterface
    {
        $this->settings[$key] = true;

        return $this;
    }

    public function disable(string $key): SettingInterface
    {
        $this->settings[$key] = false;

        return $this;
    }
}
