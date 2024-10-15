<?php

namespace App\Http\Controllers;

use App\Models\CourseTrack;
use Illuminate\Http\Request;

class CourseTrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CourseTrack::create($request->all());

        toastr()->success('Course track created successfully.');
        return redirect()->route('course.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseTrack  $courseTrack
     * @return \Illuminate\Http\Response
     */
    public function show(CourseTrack $courseTrack)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseTrack  $courseTrack
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseTrack $courseTrack)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseTrack  $courseTrack
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseTrack $courseTrack)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseTrack  $courseTrack
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseTrack $courseTrack)
    {
        //
    }
}
