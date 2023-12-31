<?php

namespace App\Services\StableDiffusion;

use App\Services\StableDiffusion\Responses\ResponseInterface;
use App\Services\StableDiffusion\Settings\Payload;

interface GeneratorInterface
{
    public function generate(Payload $payload): ResponseInterface;
}
