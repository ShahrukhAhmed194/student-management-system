<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'track_num',
        'title',
        'duration',
        'details',
    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }
}
