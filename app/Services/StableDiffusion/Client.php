<?php

namespace App\Services\StableDiffusion;

use App\Services\StableDiffusion\Settings\OverrideSetting;
use App\Services\StableDiffusion\Settings\Payload;

class Client
{
    private string $response;

    private $data;

    public function __construct(private \GuzzleHttp\Client $client)
    {
    }

    public function post(string $endpoint, Payload $payload, ?OverrideSetting $overrideSetting = null)
    {
        if ($overrideSetting) {
            $payload->overrideSettings($overrideSetting->toArray());
        }

        try {
            $response = $this->client->post($endpoint, [
                'json' => $payload->toArray()
            ]);
        }catch (\Exception $e) {
        }

        $this->response = $response->getBody()->getContents();
        $this->data = json_decode($this->response);

        return $this->data;
    }

    public function get(string $endpoint): array
    {
        $response = $this->client->get($endpoint);

        $this->response = $response->getBody()->getContents();
        $this->data = json_decode($this->response);

        return $this->data;
    }
}
