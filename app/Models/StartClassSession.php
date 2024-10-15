<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StartClassSession extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'class_session_id',
        'uuid',
        'meeting_id',
        'start_url',
        'join_url',
        'zoom_response',
        'status',
        'created_at',
        'updated_at',
    ];

}
