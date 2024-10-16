<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badges extends Model
{
    use HasFactory;

      protected $fillable = [
        'title', 'image_link', 'track_id', 'level_id'
    ];
}
