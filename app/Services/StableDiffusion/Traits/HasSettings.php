<?php

namespace App\Services\StableDiffusion\Traits;

use Illuminate\Support\Collection;

trait HasSettings
{
    protected Collection $settings;

    protected function bootHasSettings()
    {
        $this->settings = collect();
    }

    public function addSetting(string $key, $value): self
    {
        $this->settings->put($key, $value);

        return $this;
    }

    public function loadSettingsFromArray(array $settings): self
    {
        $this->settings = $this->settings->merge($settings);

        return $this;
    }

    public function removeSetting(string $key): self
    {
        $this->settings->forget($key);

        return $this;
    }

    public function enableSetting(string $key): self
    {
        $this->settings->put($key, true);

        return $this;
    }

    public function disableSetting(string $key): self
    {
        $this->settings->put($key, false);

        return $this;
    }

    public function getSettings(): array
    {
        return $this->settings->toArray();
    }

    public function getSettingsJson(): string
    {
        return json_encode($this->settings);
    }
}
