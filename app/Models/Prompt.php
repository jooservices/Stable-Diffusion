<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'prompt',
        'negative_prompt',
        'extra',
    ];

    protected $casts = [
        'extra' => 'array',
    ];
}
