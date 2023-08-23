<?php

namespace App\Jobs;

use App\Services\StableDiffusion\Txt2ImgService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateTxt2Img implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    public $currentRetryCount = 1;

    public $maxRetries = 7; // 3, 9, 27, 81, 243, 729, 2187 seconds

    public $backoffFactor = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $model)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $service = app(Txt2ImgService::class);
        $respond = $service->isCompleted();

        if ($respond === true) {
            $service->generate([], ['sd_model_checkpoint' => $this->model]);

            return;
        }

        $this->release((int) $respond->eta_relative * 2);
    }

    public function failed(Exception $e)
    {
        if ($this->currentRetryCount <= $this->maxRetries) {
            $this->delay(now()->addSeconds($this->backoffFactor ** $this->currentRetryCount));
            $this->currentRetryCount += 1;

            return dispatch($this);
        }
    }
}
