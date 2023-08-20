<?php

namespace App\Console\Commands\StableDiffusion;

use App\Models\Queue;
use App\Services\StableDiffusion\APIs\SdApi;
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
    public function handle(SdApi $api, Txt2ImgService $service)
    {
        if (!$api->isCompleted()) {
            return;
        }

        $queue = Queue::whereNull('started_at')
            ->where('status', 'init')->first();

        $queue->update([
            'started_at' => now(),
            'status' => 'processing'
        ]);

        $payload = $queue->toArray();

        $service->prompt->addManyValues($queue->prompt);
        if ($queue->negative_prompt) {
            $service->negativePrompt->addManyValues($queue->negative_prompt);
        }
        unset($payload['prompt']);
        unset($payload['negative_prompt']);

        $service->payload->loadSettingsFromArray($payload);
        $service->overrideSetting->loadSettingsFromArray($queue->override_settings);

        $response = $service->generate($queue->uuid);

        if ($response) {
            $queue->update([
                'result' => $response->getInfo(),
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        }
    }
}
