<?php

namespace App\Services\StableDiffusion\Prompts\Providers;

class Quality implements ProviderInterface
{
    public function getTokens(): string
    {
        return '(masterpiece, 8k uhd, high-res,HDR, extreme detailed, intricate details, best quality, professional, highly detailed)';
    }
}
