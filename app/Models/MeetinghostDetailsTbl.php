<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetinghostDetailsTbl extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'meetinghost_details_tbl';
    public $timestamps = false;
    
    protected $fillable = [
        'meeting_rowid',
        'meeting_id',
        'start_datetime',
        'end_datetime',
        'meetingid_topic',
        'meeting_uuid',
        'status',
        'created_date',
    ];
}