<?php

namespace App\Services\StableDiffusion;

use App\Services\StableDiffusion\APIs\SdApi;
use App\Services\StableDiffusion\Prompts\Prompt;
use App\Services\StableDiffusion\Responses\ResponseInterface;
use App\Services\StableDiffusion\Settings\Payload;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class StableDiffusionService
{
    private Prompt $prompt;
    private Prompt $negativePrompt;

    private GeneratorInterface $generator;

    private ResponseInterface $response;

    public function models(): Collection
    {
        $storage = Storage::disk('stable-diffusion');
        $files = $storage->files('models/Stable-diffusion');
        foreach ($files as $index => $file) {
            $pathInfo = pathinfo($file, PATHINFO_EXTENSION);
            if (!in_array($pathInfo, ['ckpt', 'safetensors'])) {
                unset($files[$index]);

                continue;
            }

            $files[$index] = str_replace('models/Stable-diffusion/', '', $file);
        }

        return collect(array_values($files));
    }

    public function prompt(string $prompt)
    {
        if (!isset($this->prompt)) {
            $this->prompt = app(Prompt::class);
        }
        $this->prompt->addManyValues($prompt);

        return $this;
    }

    public function negativePrompt(string $prompt)
    {
        if (!isset($this->negativePrompt)) {
            $this->negativePrompt = app(Prompt::class);
        }
        $this->negativePrompt->addManyValues($prompt);

        return $this;
    }

    public function txt2img()
    {
        $this->generator = app(Txt2ImgService::class);

        return $this;
    }

    public function generate(Payload $payload)
    {
        if (isset($this->prompt)) {
            $payload->setPrompt($this->prompt);
        }

        if (isset($this->negativePrompt)) {
            $payload->setNegativePrompt($this->negativePrompt);
        }

        $this->response = $this->generator->generate($payload);

        return $this;
    }

    public function save(string $fileName)
    {
        $this->response->saveImages($fileName);

        return $this;
    }

    public function isCompleted(): bool
    {
        return app(SdApi::class)->isCompleted();
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
