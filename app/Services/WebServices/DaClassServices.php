<?php

namespace App\Services\WebServices;

use App\DAO\WebDao\{DaClassDao};

class DaClassServices{

    protected $da_class_dao;

    public function __construct()
    {
        $this->da_class_dao = new DaClassDao();
    }

    public function getParamsForClassFilter($request)
    {
        $search_parameters = array(
            'day' => (!empty($request->day) ? $request->day : NULL),
            'time' => (!empty($request->time) ? $request->time : NULL),
            'track_num' => (!empty($request->track_num) ? $request->track_num : NULL),
            'status' => (isset($request->status) ? $request->status : NULL),
        );

        return $search_parameters;
    }

    public function getClassListAfterFiltering($search_parameters)
    {
        return $this->da_class_dao->fetchClassListUsingSearchParams($search_parameters);
    }
}
