<?php

namespace App\Services\StableDiffusion\Prompts;

interface PromptInterface
{
    public function add(string $token): self;
    public function remove (string $token): self;

    public function loadFromFile(string $path): self;

    public function getTokens(): array;

    public function toJson(): string;

    public function toString(): string;
}
