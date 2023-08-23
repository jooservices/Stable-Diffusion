<?php

namespace App\Services\StableDiffusion\Prompts\Providers;

use App\Models\Prompt;
use ReflectionClass;

abstract class AbstractProvider implements ProviderInterface
{
    protected array $tokens = [];

    public function getTokens(): string
    {
        if (empty($this->tokens)) {
            return '';
        }

        return '('.implode(',', $this->tokens).')';
    }

    public function loadFromDatabase(string $prompt): self
    {
        $prompt = Prompt::where('group', strtolower($this->getClassname()))
            ->where('prompt', $prompt)
            ->first();

        if (! $prompt) {
            return $this;
        }

        $this->tokens[] = $prompt->prompt;

        if ($prompt->extra) {

            $this->tokens = array_merge($this->tokens, $prompt->extra['style']);
        }

        return $this;
    }

    private function getClassname(): string
    {
        $reflect = new ReflectionClass($this);

        return $reflect->getShortName();
    }
}
