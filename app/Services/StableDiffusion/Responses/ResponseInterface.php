<?php

namespace App\Services\StableDiffusion\Responses;

interface ResponseInterface
{
    public function getResponse(): ?string;

    public function getData(): ?\stdClass;
}
