<?php

namespace App\Services\StableDiffusion\Settings;

interface SettingInterface
{
    public function set(string $key, mixed $value): self;
    public function get(string $key): mixed;

    public function toArray(): array;
    public function toJson(): string;

    public function enable(string $key): self;
    public function disable(string $key): self;
}
