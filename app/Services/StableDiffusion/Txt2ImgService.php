<?php

namespace App\Services\StableDiffusion;

use App\Services\StableDiffusion\APIs\SdApi;
use App\Services\StableDiffusion\Prompts\Prompt;
use App\Services\StableDiffusion\Responses\ResponseInterface;
use App\Services\StableDiffusion\Settings\OverrideSetting;
use App\Services\StableDiffusion\Settings\Payload;

class Txt2ImgService implements GeneratorInterface
{
    public function __construct(
        private SdApi $client,
    ) {
    }

    public function generate(Payload $payload): ResponseInterface
    {
        return $this->client->txt2img($payload);
    }
}
