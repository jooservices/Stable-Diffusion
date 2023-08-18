<?php

namespace App\Services\StableDiffusion;

use App\Services\StableDiffusion\Settings\OverrideSetting;
use App\Services\StableDiffusion\Settings\Payload;

interface GeneratorInterface
{
    public function generate(Payload $payload, ?OverrideSetting $overrideSetting);
}
