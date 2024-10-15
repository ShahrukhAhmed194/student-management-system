<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelInfo extends Model
{
    use HasFactory;

      protected $fillable = [
        'track_id',
        'title',
        'details',
        'final_outcome',
        'duration',
        'learning_outcomes',
    ];
}
