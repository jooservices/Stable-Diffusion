<?php

namespace App\Services\StableDiffusion;

use App\Services\StableDiffusion\APIs\SdApi;
use App\Services\StableDiffusion\Prompts\Prompt;
use App\Services\StableDiffusion\Settings\OverrideSetting;
use App\Services\StableDiffusion\Settings\Payload;
use stdClass;

class Txt2ImgService implements GeneratorInterface
{
    public function __construct(
        private SdApi $client,
        public Prompt $prompt,
        public Prompt $negativePrompt,
        private Payload $payload,
        private OverrideSetting $overrideSetting,
    )
    {
        $this->prompt->loadFromFile('stable-diffusion/prompts');
        $this->negativePrompt->loadFromFile('stable-diffusion/negative_prompts');
    }

    public function generate(): ?stdClass
    {
        $this->payload->setPrompt($this->prompt);
        $this->payload->setNegativePrompt($this->negativePrompt);

        return $this->client->txt2img($this->payload, $this->overrideSetting);
    }
}
