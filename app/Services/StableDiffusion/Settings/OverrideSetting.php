<?php

namespace App\Services\StableDiffusion\Settings;

use App\Services\StableDiffusion\Interfaces\HasSettingInterface;
use App\Services\StableDiffusion\Traits\HasSettings;

class OverrideSetting implements HasSettingInterface
{
    use HasSettings;

    public function __construct()
    {
        $this->bootHasSettings();
    }

    public function setModelCheckPoint(string $model): self
    {
        $this->addSetting('sd_model_checkpoint', $model);

        return $this;
    }
}
