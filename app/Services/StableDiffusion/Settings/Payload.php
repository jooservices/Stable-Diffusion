<?php

namespace App\Services\StableDiffusion\Settings;

use App\Services\StableDiffusion\Interfaces\HasSettingInterface;
use App\Services\StableDiffusion\Prompts\Prompt;
use App\Services\StableDiffusion\Traits\HasSettings;

class Payload implements HasSettingInterface
{
    use HasSettings;

    public function __construct()
    {
        $this->bootHasSettings();
        $this->addSetting('sampler_name', 'Euler')
            ->addSetting('seed', -1)
            ->addSetting('width', 768)
            ->addSetting('height', 768)
            ->addSetting('send_images', true)
            ->addSetting('save_images', false)
            ->addSetting('steps', 20)
            ->addSetting('restore_faces', true)
            ->addSetting('cfg_scale', 6.5)
            ->addSetting('enable_hr', true)
            ->addSetting('hr_upscaler', 'Latent')
            ->addSetting('denoising_strength', 0.35);
    }

    public function setPrompt(Prompt $prompt): self
    {
        $this->addSetting('prompt', $prompt->getValuesString());

        return $this;
    }

    public function setNegativePrompt(Prompt $prompt): self
    {
        $this->addSetting('negative_prompt', $prompt->getValuesString());

        return $this;
    }

    public function setSteps(int $steps): self
    {
        if ($steps > 150) {
            $steps = 150;
        } elseif ($steps < 1) {
            $steps = 1;
        }

        $this->addSetting('steps', $steps);

        return $this;
    }

    public function enableHr(): self
    {
        $this->enableSetting('enable_hr');

        return $this;
    }

    public function disableHr(): self
    {
        $this->disableSetting('enable_hr');

        return $this;
    }

    public function enableRestoreFaces(): self
    {
        $this->enableSetting('restore_faces');

        return $this;
    }

    public function disableRestoreFaces(): self
    {
        $this->disableSetting('restore_faces');

        return $this;
    }

    public function enableSendImages(): self
    {
        $this->enableSetting('send_images');

        return $this;
    }

    public function disableSendImages(): self
    {
        $this->disableSetting('send_images');

        return $this;
    }

    public function enableSaveImages(): self
    {
        $this->enableSetting('save_images');

        return $this;
    }

    public function disableSaveImages(): self
    {
        $this->disableSetting('save_images');

        return $this;
    }

    public function overrideSettings(OverrideSetting $settings)
    {
        $this->addSetting('override_settings', $settings->getSettings());

        return $this;
    }
}
