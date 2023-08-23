<?php

namespace App\Services\StableDiffusion;

use App\Services\StableDiffusion\Settings\Payload;
use Exception;

class Client
{
    public function __construct(private readonly \GuzzleHttp\Client $client)
    {
    }

    public function post(string $endpoint, Payload $payload): ?string
    {
        try {
            $response = $this->client->post($endpoint, [
                'json' => $payload->getSettings(),
            ]);
        } catch (Exception $e) {
            return null;
        }

        return $response->getBody()->getContents();
    }

    public function get(string $endpoint): ?string
    {
        try {
            $response = $this->client->get($endpoint);
        } catch (Exception $e) {
            return null;
        }

        return $response->getBody()->getContents();
    }
}
