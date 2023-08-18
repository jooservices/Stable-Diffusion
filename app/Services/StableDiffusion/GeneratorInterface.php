<?php

namespace App\Services\StableDiffusion;

interface GeneratorInterface
{
    public function generate(string $fileName, ?string $dir = null): ?\stdClass;
}
