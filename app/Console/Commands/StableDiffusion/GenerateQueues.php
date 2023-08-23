<?php

namespace App\Console\Commands\StableDiffusion;

use App\Models\Queue;
use App\Services\StableDiffusion\Prompts\Prompt;
use App\Services\StableDiffusion\Settings\OverrideSetting;
use App\Services\StableDiffusion\Settings\Payload;
use App\Services\StableDiffusion\StableDiffusionService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateQueues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stable-diffusion:generate {--prompt=} {--subprompt=} {--payload=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate queues for all models based on a prompt';

    /**
     * Execute the console command.
     */
    public function handle(StableDiffusionService $service)
    {
        $overridePayload = [];
        collect(explode(',', $this->option('payload')))->map(function ($item, $key) use (&$overridePayload) {
            $data = explode('=', $item);
            if (count($data) === 2) {
                $overridePayload[$data[0]] = $data[1];
            }
        });

        $service->models()->each(function ($model) use ($overridePayload) {
            $payload = app(Payload::class)
                ->loadSettingsFromArray($overridePayload)
                ->overrideSettings(
                    app(OverrideSetting::class)
                        ->setModelCheckPoint($model)
                );

            $prompt = app(Prompt::class);
            $prompt->addManyValues($this->option('prompt'));
            $prompt->quality();
            $payload->setPrompt($prompt);

            Queue::create([
                'uuid' => Str::orderedUuid(),
                'payload' => $payload->getSettings(),
            ]);

            if (!$this->option('subprompt')) {
                return;
            }

            collect(explode(',', $this->option('subprompt')))->each(function ($item, $key) use ($payload, $prompt) {
                $prompt->addValue($item);
                $payload->setPrompt($prompt);

                Queue::create([
                    'uuid' => Str::orderedUuid(),
                    'payload' => $payload->getSettings(),
                ]);
            });
        });
    }
}
