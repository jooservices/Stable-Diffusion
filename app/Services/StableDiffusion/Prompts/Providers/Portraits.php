<?php

namespace App\Services\StableDiffusion\Prompts\Providers;

class Portraits extends AbstractProvider
{
    protected array $tokens = [
        'headshot',
        'posed',
        'candid',
        'gender identity',
        'cultural identity',
        'photorealistic',
        'expressive emotions',
        'soft focus',
        'close up',
        'sideview',
        'eye contact',
        'age range',
        'full depth of field',
        'shallow depth of field',
    ];
}
