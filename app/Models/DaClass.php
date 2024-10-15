<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'teacher_id',
        'coordinator_id',
        'course_id',
        'track_id',
        'level_id',
        'status',
        'notif_enable',
        'isZoomAutomated'
    ];

    public function teacher()
    {
        return $this->belongsTo('App\Models\User', 'teacher_id');
    }
    public function coordinator()
    {
        return $this->belongsTo('App\Models\User', 'coordinator_id');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }

    public function track()
    {
        return $this->belongsTo('App\Models\CourseTrack', 'track_id');
    }

    public function level()
    {
        return $this->belongsTo('App\Models\CourseLevel', 'level_id');
    }

    public function class_schedules()
    {
        return $this->hasMany(ClassSchedule::class, 'class_id');
    }
}
