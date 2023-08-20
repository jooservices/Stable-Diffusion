<?php

namespace Tests\Feature\Services;

use App\Services\StableDiffusion\Txt2ImgService;
use Tests\TestCase;

class StableDiffusionServiceTest extends TestCase
{
    public function testText2Image()
    {
        $service = app(Txt2ImgService::class);
        $service->generate('test');
    }
}
