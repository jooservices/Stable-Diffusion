<?php

namespace App\Services\StableDiffusion;

interface GeneratorInterface
{
    public function generate(): ?\stdClass;
}
