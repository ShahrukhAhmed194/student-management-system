<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tracks()
    {
        return $this->hasMany(CourseTrack::class, 'course_id');
    }

    public function levels()
    {
        return $this->hasMany(CourseLevel::class, 'course_id');
    }
}
