<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'track_id',
        'level_num',
        'title',
        'details',
        'final_outcome',
        'duration',
        'learning_outcomes',
    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }

    public function track()
    {
        return $this->belongsTo('App\Models\CourseTrack', 'track_id');
    }
}
