<?php

namespace App\Services\StableDiffusion\Prompts;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class Prompt implements PromptInterface
{
    protected array $tokens = [];

    private Filesystem $filesystem;

    public function __construct()
    {
        $this->filesystem = Storage::disk('local');
    }

    public function add(string $token): PromptInterface
    {
        $this->tokens[] = $token;

        return $this;
    }

    public function remove(string $token): PromptInterface
    {
        $this->tokens[] = $token;

        return $this;
    }

    public function loadFromFile(string $path): PromptInterface
    {
        $tokens = $this->filesystem->get($path);
        $this->tokens = array_merge(explode(',', $tokens));

        return $this;
    }

    public function getTokens(): array
    {
        return array_unique($this->tokens);
    }

    public function toJson(): string
    {
        return json_encode( $this->getTokens());
    }

    public function toString(): string
    {
        return implode(',', $this->getTokens());
    }
}
