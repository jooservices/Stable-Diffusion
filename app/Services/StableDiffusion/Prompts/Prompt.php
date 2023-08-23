<?php

namespace App\Services\StableDiffusion\Prompts;

use App\Services\StableDiffusion\Interfaces\HasValuesInterface;
use App\Services\StableDiffusion\Prompts\Providers\ProviderInterface;
use App\Services\StableDiffusion\Traits\HasValues;
use BadMethodCallException;
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
            throw new BadMethodCallException("Provider {$name} does not exist.");
        }

        $method = array_shift($arguments);
        if (!$method) {
            $this->addValue($provider->getTokens());

            return $this;
        }

        if (!method_exists($provider, $method)) {
            throw new BadMethodCallException("Method {$method} does not exist.");
        }

        $this->addValue(
            call_user_func_array([$provider, $method], $arguments)->getTokens()
        );

        return $this;
    }

    public function __get(string $name): string
    {
        $provider = $this->getProvider(ucfirst($name));
        if (!$provider) {
            throw new BadMethodCallException("Method {$name} does not exist.");
        }

        return $provider->getTokens();
    }

    private function getProvider(string $provider): ?ProviderInterface
    {
        $className = 'App\\Services\\StableDiffusion\\Prompts\\Providers\\' . ucfirst($provider);
        if (class_exists($className)) {
            return app($className);
        }

        return null;
    }
}
