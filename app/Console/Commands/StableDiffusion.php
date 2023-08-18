<?php

namespace App\Console\Commands;

use App\Jobs\GenerateTxt2Img;
use App\Services\StableDiffusionService;
use Illuminate\Console\Command;

class StableDiffusion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stable-diffusion:generate';

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
            GenerateTxt2Img::dispatch($model);
        }
    }
}
