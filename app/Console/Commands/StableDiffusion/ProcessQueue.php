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

        $queue = Queue::where('completed', false)->first();

        $payload = $queue->toArray();
        unset($payload['override_settings']);
        $service->prompt->addMany($queue->prompt);
        if ($queue->negative_prompt) {
            $service->negativePrompt->addMany($queue->negative_prompt);
        }
        unset($payload['prompt']);
        unset($payload['negative_prompt']);

        $service->payload->loadFromArray($payload);
        $service->overrideSetting->loadFromArray($queue->override_settings);

        if ($data = $service->generate($queue->id)) {
            $queue->update([
                'result' => json_decode($data->info, true),
                'completed' => true,
            ]);
        }
    }
}
