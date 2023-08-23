<?php

namespace App\Console\Commands\StableDiffusion;

use App\Models\Queue;
use App\Services\StableDiffusion\APIs\SdApi;
use App\Services\StableDiffusion\Prompts\Prompt;
use App\Services\StableDiffusion\Settings\Payload;
use App\Services\StableDiffusion\StableDiffusionService;
use App\Services\StableDiffusion\Txt2ImgService;
use Illuminate\Console\Command;

class ProcessQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stable-diffusion:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(StableDiffusionService $service)
    {
        if (!$service->isCompleted()) {
            return;
        }

        $queue = Queue::whereNull('started_at')
            ->where('status', 'init')->first();

        if (!$queue) {
            return;
        }

        $queue->update([
            'started_at' => now(),
            'status' => 'processing',
        ]);

        $negativePrompt = app(Prompt::class);
        $negativePrompt->loadValuesFromFile('stable-diffusion/negative_prompts');

        $payload = app(Payload::class)
            ->loadSettingsFromArray($queue->payload)
            ->setNegativePrompt($negativePrompt);

        $response = $service
            ->txt2img()
            ->generate($payload)
            ->save($queue->uuid)
            ->getResponse();

        if (!$response) {
            $queue->update([
                'status' => 'failed',
            ]);

            return;
        }

        $queue->update([
            'result' => $response->getInfo(),
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
