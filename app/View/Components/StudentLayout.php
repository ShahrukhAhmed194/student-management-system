<?php

namespace App\View\Components;

use App\Models\Student;
use Illuminate\View\Component;

class StudentLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.student-layout', [
            'student' => Student::where('user_id', auth()->user()->id)->first(),
        ]);
    }
}
