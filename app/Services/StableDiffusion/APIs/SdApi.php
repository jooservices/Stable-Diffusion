<?php

namespace App\Services\StableDiffusion\APIs;

use App\Services\StableDiffusion\Client;
use App\Services\StableDiffusion\Settings\OverrideSetting;
use App\Services\StableDiffusion\Settings\Payload;

class SdApi
{
    public const SD_API_URL = 'http://127.0.0.1:7860/sdapi/v1/';

    public function __construct(private Client $client)
    {
    }

    public function get(string $endpoint): ?\stdClass
    {
        $this->client->get(self::SD_API_URL . $endpoint);

        return $this->client->getData();
    }

    public function post(string $endpoint, Payload $payload, ?OverrideSetting $overrideSetting): ?\stdClass
    {
        $this->client->post(
            self::SD_API_URL . $endpoint,
            $payload,
            $overrideSetting
        );

        return $this->client->getData();
    }

    public function txt2img(Payload $payload, ?OverrideSetting $overrideSetting): ?\stdClass
    {
        return $this->post('txt2img', $payload, $overrideSetting);
    }

    public function options(): ?\stdClass
    {
        return $this->get('options');
    }

    public function progress()
    {
        return $this->client->get('progress?skip_current_image=true');
    }

    public function isCompleted(): bool
    {
        return $this->progress()->progress === 0.0;
    }
}
