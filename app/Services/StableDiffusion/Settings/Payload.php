<?php

namespace App\Services\StableDiffusion\Settings;

use App\Services\StableDiffusion\Prompts\PromptInterface;

class Payload extends BaseSetting
{
    public function __construct()
    {
        $this->loadDefault();
    }

    public function loadDefault()
    {
        $this->settings = [
            'sampler_name' => 'Euler',
            'seed' => -1,
            'width' => 768,
            'height' => 768,
            'send_images' => true,
            'save_images' => false,
            'steps' => 150,
            'restore_faces' => true,
            'cfg_scale' => 6.5,
            'enable_hr' => true,
            'hr_upscaler' => 'Latent',
            'denoising_strength' => 0.35,
        ];
    }

    public function setPrompt(PromptInterface $prompt): self
    {
        $this->set('prompt', $prompt->toString());

        return $this;
    }

    public function setNegativePrompt(PromptInterface $prompt): self
    {
        $this->set('negative_prompt', $prompt->toString());

        return $this;
    }

    public function setSteps(int $steps): self
    {
        if ($steps > 150) {
            $steps = 150;
        } elseif ($steps < 1) {
            $steps = 1;
        }

        $this->set('steps', $steps);

        return $this;
    }

    public function enableHr(): self
    {
        $this->enable('enable_hr');

        return $this;
    }

    public function disableHr(): self
    {
        $this->disable('enable_hr');

        return $this;
    }

    public function enableRestoreFaces(): self
    {
        $this->enable('restore_faces');

        return $this;
    }

    public function disableRestoreFaces(): self
    {
        $this->disable('restore_faces');

        return $this;
    }

    public function enableSendImages(): self
    {
        $this->enable('send_images');

        return $this;
    }

    public function disableSendImages(): self
    {
        $this->disable('send_images');

        return $this;
    }

    public function enableSaveImages(): self
    {
        $this->enable('save_images');

        return $this;
    }

    public function disableSaveImages(): self
    {
        $this->disable('save_images');

        return $this;
    }

    public function overrideSettings(array $settings)
    {
        $this->set('override_settings', $settings);

        return $this;
    }
}
