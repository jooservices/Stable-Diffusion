<?php

namespace App\Services\StableDiffusion;

use App\Services\StableDiffusion\APIs\SdApi;
use App\Services\StableDiffusion\Prompts\Prompt;
use App\Services\StableDiffusion\Responses\ResponseInterface;
use App\Services\StableDiffusion\Responses\Txt2Img;
use App\Services\StableDiffusion\Settings\OverrideSetting;
use App\Services\StableDiffusion\Settings\Payload;
use Illuminate\Support\Facades\Storage;
use stdClass;

class Txt2ImgService implements GeneratorInterface
{
    public function __construct(
        private SdApi $client,
        public Prompt $prompt,
        public Prompt $negativePrompt,
        public Payload $payload,
        public OverrideSetting $overrideSetting,
    )
    {
        $this->prompt->loadValuesFromFile('stable-diffusion/prompts');
        $this->negativePrompt->loadValuesFromFile('stable-diffusion/negative_prompts');
    }

    public function generate(string $fileName): ResponseInterface
    {
        $this->payload->setPrompt(
            $this->prompt->quality()
        );
        $this->payload->setNegativePrompt($this->negativePrompt);
        $this->payload->overrideSettings($this->overrideSetting);

        $response = $this->client->txt2img($this->payload);
        $response->saveImages($fileName);

        return $response;
    }
}
