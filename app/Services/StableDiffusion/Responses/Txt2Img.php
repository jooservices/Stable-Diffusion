<?php

namespace App\Services\StableDiffusion\Responses;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use stdClass;

class Txt2Img extends Response
{
    private Filesystem $filesystem;

    public function saveImages(string $fileName): array
    {
        $this->filesystem = Storage::disk('local');

        $images = [];
        foreach ($this->getImages() as $index => $image) {
            $imageFile = 'images/'.$fileName.'_'.$index.'.png';
            $images[] = $imageFile;

            $this->filesystem->put(
                $imageFile,
                base64_decode($image)
            );
        }

        return $images;
    }

    public function getImages(): array
    {
        return $this->getData()->images;
    }

    public function getParameters(): stdClass
    {
        return $this->getData()->parameters;
    }

    public function getInfo(): stdClass
    {
        return json_decode($this->getData()->info);
    }
}
