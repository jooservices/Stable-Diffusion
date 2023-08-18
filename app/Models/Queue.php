<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'prompt',
        'negative_prompt',
        'sampler_name',
        'hr_upscaler',
        'override_settings',
        'model_checkpoint',
        'seed',
        'steps',
        'width',
        'height',
        'cfg_scale',
        'denoising_strength',
        'completed',
        'result'
    ];

    protected $casts = [
        'override_settings' => 'array',
        'result' => 'array',
        'completed' => 'boolean',
    ];
}
