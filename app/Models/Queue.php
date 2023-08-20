<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
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
        'result',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'override_settings' => 'array',
        'result' => 'array',
        'status' => 'string',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
