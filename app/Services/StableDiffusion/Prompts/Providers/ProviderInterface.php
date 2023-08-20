<?php

namespace App\Services\StableDiffusion\Prompts\Providers;

interface ProviderInterface
{
    public function getTokens(): string;
}
