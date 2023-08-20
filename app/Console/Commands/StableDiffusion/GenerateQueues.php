<?php

namespace App\Console\Commands\StableDiffusion;

use App\Models\Queue;
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
    public function handle()
    {
        $models = app(StableDiffusionService::class)->models();

        collect(explode(',', $this->option('payload')))->map(function ($item, $key) use (&$payload) {
            $data = explode('=', $item);
            if (count($data) == 2) {
                $payload[$data[0]] = $data[1];
            }
        });

        if ($subPrompts = $this->option('subprompt')) {
            $subPrompts = explode(',', $subPrompts);
        }

        foreach ($models as $model) {
            if (isset($subPrompts)) {
                foreach ($subPrompts as $subPrompt) {
                    $payload['prompt'] = $this->option('prompt') . ',' . $subPrompt;
                }
            } else {
                $payload['prompt'] = $this->option('prompt');
            }

            Queue::create(array_merge([
                'uuid' => Str::orderedUuid(),
                'override_settings' => [
                    'sd_model_checkpoint' => $model,
                ]
            ], $payload));
        }
    }
}
