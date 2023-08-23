<?php

namespace Tests\Feature\Services;

use App\Services\StableDiffusion\Prompts\Prompt;
use Tests\TestCase;

class PromptTest extends TestCase
{
    public function testAuthorName()
    {
        $prompt = app(Prompt::class);
        dd($prompt->author('loadFromDatabase', 'Giacomo Balla'));
    }
}
