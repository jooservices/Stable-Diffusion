<?php

namespace App\Services\StableDiffusion\Prompts\Providers;

class Quality extends AbstractProvider
{
    protected array $tokens = [
        'masterpiece',
        '8k uhd',
        'high-res',
        'HDR',
        'extreme detailed',
        'intricate details',
        'best quality',
        'professional',
        'highly detailed',
    ];
}
