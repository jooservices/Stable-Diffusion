<?php

namespace App\Services\StableDiffusion;

use App\Services\StableDiffusion\Settings\OverrideSetting;
use App\Services\StableDiffusion\Settings\Payload;

class Client
{
    private string $response;

    private ?\stdClass $data;

    public function __construct(private \GuzzleHttp\Client $client)
    {
    }

    public function post(string $endpoint, Payload $payload, ?OverrideSetting $overrideSetting = null): ?\stdClass
    {
        if ($overrideSetting) {
            $payload->overrideSettings($overrideSetting->toArray());
        }

        try {
            $response = $this->client->post($endpoint, [
                'json' => $payload->toArray()
            ]);
        }catch (\Exception $e) {

            return null;
        }

        $this->response = $response->getBody()->getContents();
        $this->data = json_decode($this->response);

        return $this->data;
    }

    public function get(string $endpoint): ?\stdClass
    {
        try {
            $response = $this->client->get($endpoint);
        }catch (\Exception $e) {
            return null;
        }

        $this->response = $response->getBody()->getContents();
        $this->data = json_decode($this->response);

        return $this->data;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function getData(): \stdClass
    {
        return $this->data;
    }
}
