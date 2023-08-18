<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StableDiffusionService
{
    public function models()
    {
        $storage = Storage::disk('stable-diffusion');
        $files = $storage->files('models/Stable-diffusion');
        foreach ($files as $index => $file)
        {
            $pathInfo = pathinfo($file, PATHINFO_EXTENSION);
            if (!in_array($pathInfo, ['ckpt', 'safetensors'])) {
                unset($files[$index]);
                continue;
            }

            $files[$index] = str_replace('models/Stable-diffusion/', '', $file);
        }

        return array_values($files);
    }
}
