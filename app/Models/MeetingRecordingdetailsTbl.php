<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingRecordingdetailsTbl extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'meeting_recordingdetails_tbl';
    public $timestamps = false;
    
    protected $fillable = [
        'meeting_rowid',
        'meeting_id',
        'meeting_uuid',
        'recording_start',
        'recording_end',
        'file_type',
        'file_size',
        'play_url',
        'download_url',
        'recording_type',
        'vimeo_videourl',
        'status',
        'created_date'
    ];
}