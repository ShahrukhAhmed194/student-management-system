<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomRecordDA extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'zoom_record_da';
    public $timestamps = false;
    
    protected $fillable = [
        'meeting_rowid',
        'meeting_id',
        'account_id',
        'topic',
        'start_time',
        'timezone',
        'meeting_uuid',
        'recording_start',
        'recording_end',
        'status',
        'recording_type',
        'vimeo_videourl',
        'vimeo_embed_html',
        'flag',
        'local_file_name',
        'raw_data',
        'created_date',
        'created_time',
    ];
}