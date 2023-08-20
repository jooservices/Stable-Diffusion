<?php

namespace App\Services\StableDiffusion;

use App\Services\StableDiffusion\Responses\ResponseInterface;

interface GeneratorInterface
{
    public function generate(string $fileName): ResponseInterface;
}
