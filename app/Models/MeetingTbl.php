<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingTbl extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql2';
    protected $table = 'meeting_tbl';
    public $timestamps = false;
    
    protected $fillable = [
        'title',
        'course_id',
        'meeting_id',
        'client_session_id',
        'meeting_password',
        'meetingid_topic',
        'meeting_date',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'joinurl',
        'zoom_uuid',
        'zoom_host_id',
        'start_url',
        'join_url',
        'speakers',
        'status',
        'is_host',
        'is_meetingdone',
        'enterprise_id',
        'created_by',
        'created_date',
    ];
}