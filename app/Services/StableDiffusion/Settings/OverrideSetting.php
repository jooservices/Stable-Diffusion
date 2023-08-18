<?php

namespace App\Services\StableDiffusion\Settings;

class OverrideSetting extends BaseSetting
{
    public function setModelCheckPoint(string $model)
    {
        $this->set('sd_model_checkpoint', $model);

        return $this;
    }
}