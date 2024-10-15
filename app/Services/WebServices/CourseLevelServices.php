<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\{CourseLevelDao};

class CourseLevelServices{

    protected $course_level_dao;
    public function __construct()
    {
        $this->course_level_dao = new CourseLevelDao();
    }

    public function getCourseTrackLevelForRoadMap()
    {
       return $this->course_level_dao->fetchCourseTrackLevelForRoadMap();
    }
}
