<?php

namespace App\Services\StableDiffusion\APIs;

use App\Services\StableDiffusion\Client;
use App\Services\StableDiffusion\Responses\Response;
use App\Services\StableDiffusion\Responses\ResponseInterface;
use App\Services\StableDiffusion\Responses\Txt2Img;
use App\Services\StableDiffusion\Settings\Payload;

class SdApi
{
    public const SD_API_URL = 'http://127.0.0.1:7860/sdapi/v1/';

    public function __construct(private Client $client)
    {
    }

    public function get(string $endpoint): ResponseInterface
    {
        return new Response($this->client->get(self::SD_API_URL.$endpoint));
    }

    public function post(string $endpoint, Payload $payload): ResponseInterface
    {
        return new Response(
            $this->client->post(
                self::SD_API_URL.$endpoint,
                $payload
            )
        );
    }

    public function txt2img(Payload $payload): ResponseInterface
    {
        $response = $this->post('txt2img', $payload);

        return new Txt2Img($response->getResponse());
    }

    public function options(): ResponseInterface
    {
        return $this->get('options');
    }

    public function progress(): ResponseInterface
    {
        return $this->get('progress?skip_current_image=true');
    }

    public function isCompleted(): bool
    {
        $progress = $this->progress()->getData()->progress;

        return $progress === 0.0 || $progress === 0;
    }
}
