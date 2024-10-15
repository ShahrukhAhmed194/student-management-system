<?php

namespace App\DAO\WebDao;

use App\Models\{CourseTrack};

class CourseTrackDao{
    
    public function fetchCourseTrackList($course_id)
    {
        return CourseTrack::where('course_id', $course_id)->get();
    }
}
