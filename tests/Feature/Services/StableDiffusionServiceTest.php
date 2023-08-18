<?php

namespace Tests\Feature\Services;

use App\Services\StableDiffusion\Txt2ImgService;
use App\Services\StableDiffusionService;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StableDiffusionServiceTest extends TestCase
{
    public function testText2Image()
    {
        $service = app(Txt2ImgService::class);
        $service->prompt->add('deep inside pussy');

        dd($service->generate());
    }
}
