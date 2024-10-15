<?php

namespace App\DAO\WebDao;

use App\Models\CourseLevel;

class CourseLevelDao{
    
    public function fetchCourseTrackLevelForRoadMap()
    {
        return CourseLevel::select('course_levels.id', 'course_levels.track_id', 'course_levels.level_num', 'course_levels.duration', 'course_tracks.track_num')
                             ->join('course_tracks', 'course_tracks.id', '=', 'course_levels.track_id')->get();
    }
}
