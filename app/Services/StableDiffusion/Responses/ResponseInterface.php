<?php

namespace App\Services\StableDiffusion\Responses;

use stdClass;

interface ResponseInterface
{
    public function getResponse(): ?string;

    public function getData(): ?stdClass;
}
