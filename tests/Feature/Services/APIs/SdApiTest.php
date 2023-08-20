<?php

namespace Tests\Feature\Services\APIs;

use App\Services\StableDiffusion\APIs\SdApi;
use App\Services\StableDiffusion\Client;
use Tests\TestCase;

class SdApiTest extends TestCase
{
    public function testIsCompleted()
    {
        $this->instance(Client::class, \Mockery::mock(Client::class, function ($mock) {
            $mock->shouldReceive('get')
                ->once()
                ->with(SdApi::SD_API_URL . 'progress?skip_current_image=true')
                ->andReturn('{
  "progress": 0,
  "eta_relative": 0,
  "state": {},
  "current_image": "string",
  "textinfo": "string"
}');
        }));
        $service = app(SdApi::class);
        $this->assertTrue($service->isCompleted());
    }
}
