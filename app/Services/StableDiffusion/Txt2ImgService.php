<?php

namespace App\Services\StableDiffusion;

use App\Services\StableDiffusion\APIs\SdApi;
use App\Services\StableDiffusion\Prompts\Prompt;
use App\Services\StableDiffusion\Settings\OverrideSetting;
use App\Services\StableDiffusion\Settings\Payload;
use Illuminate\Support\Facades\Storage;
use stdClass;

class Txt2ImgService implements GeneratorInterface
{
    public function __construct(
        private SdApi $client,
        public Prompt $prompt,
        public Prompt $negativePrompt,
        public Payload $payload,
        public OverrideSetting $overrideSetting,
    )
    {
        $this->prompt->loadFromFile('stable-diffusion/prompts');
        $this->negativePrompt->loadFromFile('stable-diffusion/negative_prompts');
    }

    public function generate(string $fileName, ?string $dir = null): ?stdClass
    {
        $this->payload->setPrompt($this->prompt);
        $this->payload->setNegativePrompt($this->negativePrompt);

        $data = $this->client->txt2img($this->payload, $this->overrideSetting);

        $filesystem = Storage::disk('local');
        $filesystem->makeDirectory('images');
        $path = 'images/';

        if($dir)
        {
            $filesystem->makeDirectory('images/' . $dir);
            $path = 'images/' . $dir . '/';
        }

        if ($data)
        {
            $images = $data->images;

            foreach ($images as $index => $image)
            {
                $filesystem->put(
                    $path. $fileName . '_' . $index . '.png',
                    base64_decode($image)
                );
            }
        }

        return $data;
    }
}
