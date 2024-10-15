<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\{CourseTrackDao};

class CourseTrackServices{

    protected $course_track_dao;

    public function __construct()
    {
        $this->course_track_dao = new CourseTrackDao();
    }

    public function getCourseTrackList($course_id)
    {
        return $this->course_track_dao->fetchCourseTrackList($course_id);
    }
}
