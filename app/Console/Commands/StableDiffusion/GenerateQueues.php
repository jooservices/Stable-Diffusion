<?php

namespace App\Console\Commands\StableDiffusion;

use App\Models\Queue;
use App\Services\StableDiffusionService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateQueues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stable-diffusion:generate {--prompt=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $models = app(StableDiffusionService::class)->models();

        foreach ($models as $model)
        {
            Queue::create([
                'uuid' => Str::orderedUuid(),
                'prompt' => $this->option('prompt'),
                'override_settings' => [
                    'sd_model_checkpoint' => $model,
                ]
            ]);
        }
    }
}
