<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    use HasFactory;

    public $fillable = [
        'prompt',
        'negative_prompt',
        'status',
    ];
}
