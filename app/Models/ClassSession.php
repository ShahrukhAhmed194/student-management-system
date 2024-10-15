<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSession extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'session_started',
        'session_ended',
        'session_date',
        'class_id',
        'teacher_id',
        'status',
        'session_id',
        'comments',
        'uuid',
        'meeting_id',
        'start_url',
        'join_url',
        'zoom_response',
        // 'recording_link',
        // 'class_status',
    ];

    public function sessionClass(){
        return $this->belongsTo('App\Models\DaClass', 'class_id');
    }

    public function teacher(){
        return $this->belongsTo('App\Models\User', 'teacher_id');
    }
    
    public function classSessionRecords()
    {
        return $this->hasMany(ClassSessionRecord::class, 'class_session_id');
    }
}