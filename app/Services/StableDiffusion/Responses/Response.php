<?php

namespace App\Services\StableDiffusion\Responses;

class Response implements ResponseInterface
{
    public function __construct(
        protected readonly ?string $response,
    )
    {
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function getData(): ?\stdClass
    {
        return json_decode($this->response);
    }
}
