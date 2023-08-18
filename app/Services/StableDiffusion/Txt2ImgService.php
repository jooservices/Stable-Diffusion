<?php

namespace App\Services\StableDiffusion;

use App\Services\StableDiffusion\APIs\SdApi;
use App\Services\StableDiffusion\Prompts\Prompt;
use App\Services\StableDiffusion\Settings\OverrideSetting;
use App\Services\StableDiffusion\Settings\Payload;

class Txt2ImgService implements GeneratorInterface
{
    public function __construct(
        private SdApi $client,
        private Prompt $prompt,
        private Prompt $negativePrompt,
    )
    {
    }

    public function loadPromptFromFile(string $path = 'stable-diffusion/prompts'): self
    {
        $this->prompt->loadFromFile($path);

        return $this;
    }

    public function addPrompt(string $prompt): self
    {
        $this->prompt->add(trim($prompt));

        return $this;
    }

    public function addPrompts(string $prompts): self
    {
        $prompts = explode(',', $prompts);
        foreach ($prompts as $prompt)
        {
            $this->addPrompt($prompt);
        }

        return $this;
    }

    public function loadNegativePromptFromFile(string $path ='stable-diffusion/negative_prompts'): self
    {
        $this->negativePrompt->loadFromFile($path);

        return $this;
    }

    public function addNegativePrompt(string $prompt): self
    {
        $this->negativePrompt->add($prompt);

        return $this;
    }

    public function addNegativePrompts(string $prompts): self
    {
        $prompts = explode(',', $prompts);
        foreach ($prompts as $prompt)
        {
            $this->negativePrompt->add($prompt);
        }

        return $this;
    }

    public function generate(?Payload $payload = null, ?OverrideSetting $overrideSetting = null): array
    {
        if (!$payload) {
            $payload = app(Payload::class);
            $payload->loadDefault();
        }

        if (!$overrideSetting) {
            $overrideSetting = app(OverrideSetting::class);
        }

        $payload->setPrompt($this->prompt);
        $payload->setNegativePrompt($this->negativePrompt);

        return $this->client->post('txt2img', $payload, $overrideSetting);
    }
}
