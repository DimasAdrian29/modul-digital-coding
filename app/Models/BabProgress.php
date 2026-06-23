<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'bab_slug',
    'bab_name',
    'answers',
    'score',
    'total',
    'passed',
    'completed',
    'completed_at',
])]
class BabProgress extends Model
{
    protected $table = 'bab_progress';

    protected function casts(): array
    {
        return [
            'answers' => 'array',
            'passed' => 'boolean',
            'completed' => 'boolean',
            'completed_at' => 'datetime',
        ];
    }
}
