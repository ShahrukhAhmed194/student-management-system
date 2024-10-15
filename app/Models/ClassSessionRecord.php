<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSessionRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_session_id',
        'recording_id',
        'uuid',
        'meeting_id',
        'recording_start', 
        'recording_end', 
        'file_type',
        'file_size', 
        'play_url', 
        'download_url', 
        'recording_type', 
        'video_id',
        'vimeo_embed_html',
        'recording_downloaded',
        'recording_uploaded',
        'recording_deleted',
        'recording_link',
        'status',
        'created_at',
        'updated_at',
    ];
    
    public function classSession(){
        return $this->belongsTo('App\Models\ClassSession', 'class_session_id');
    }
}
