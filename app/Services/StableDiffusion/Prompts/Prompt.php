<?php

namespace App\Services\StableDiffusion\Prompts;

use App\Services\StableDiffusion\Interfaces\HasValuesInterface;
use App\Services\StableDiffusion\Prompts\Providers\Quality;
use App\Services\StableDiffusion\Traits\HasValues;
use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * @method self quality()
 */
class Prompt implements HasValuesInterface
{
    use HasValues;

    public function __construct(private Filesystem $filesystem)
    {
        $this->bootHasValues();
    }

    public function __call(string $name, array $arguments): self
    {
        $provider = $this->getProvider($name);
        if (!$provider) {
            throw new \BadMethodCallException("Method {$name} does not exist.");
        }

        $this->addValue(app($provider)->getTokens());

        return $this;
    }

    private function getProvider(string $provider): ?string
    {
        $className = 'App\\Services\\StableDiffusion\\Prompts\\Providers\\' . ucfirst($provider);
        if (class_exists($className)) {
            return $className;
        }

        return null;
    }
}
