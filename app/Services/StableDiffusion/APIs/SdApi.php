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

    public function get(string $endpoint): array
    {
        return $this->client->get(self::SD_API_URL . $endpoint);
    }

    public function post(string $endpoint, Payload $payload, ?OverrideSetting $overrideSetting)
    {
        return $this->client->post(
            self::SD_API_URL . $endpoint,
            $payload,
            $overrideSetting
        );
    }

    public function isCompleted()
    {
        $respond = $this->client->get('progress?skip_current_image=true');

        if ($respond->progress === 0.0) {
            return true;
        }

        return $respond;
    }
}
