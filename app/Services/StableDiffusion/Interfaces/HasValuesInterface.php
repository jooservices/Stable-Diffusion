<?php

namespace App\Services\StableDiffusion\Interfaces;

interface HasValuesInterface
{
    public function addValue(string $token): self;

    public function addManyValues(string $tokens): self;

    public function removeValue(string $token): self;

    public function loadValuesFromFile(string $path): self;

    public function loadValuesFromArray(array $values): self;

    public function getValues(): array;

    public function getValueJson(): string;

    public function getValuesString(): string;
}
