<?php

namespace App\Http\Controllers;

use App\Models\DaClass;
use App\Models\Quiz;
use App\Models\Student;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;

class StudentQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('quiz.assesment.index', [
            'assesments' => StudentQuiz::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->class_id && $request->quiz_id) {
            return view('quiz.assesment.create', [
                'classes' => DaClass::where('teacher_id', auth()->user()->id)
                            ->where('status', 1)->get(),
                'quizzes' => Quiz::all(),
                // 'teacher' => DaClass::find($request->class_id),
                'students' => Student::where('class_id', $request->class_id)
                              ->where('status', 1)->get(),
                'selected' => [
                    'class_id' => $request->class_id,
                    'teacher_id' => DaClass::find($request->class_id)->teacher_id,
                    'quiz_id'  => $request->quiz_id,
                ]
            ]);
        }

        return view('quiz.assesment.create', [
            'classes' => DaClass::where('teacher_id', auth()->user()->id)
                         ->where('status', 1)
                         ->get(),
            'quizzes' => Quiz::all(),
            // 'teacher' => User::where('user_type', 'Teacher')->get(),
            'students' => [],
            'selected' => [
                'class_id' => "",
                'teacher_id' => "",
                'quiz_id'  => "",
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        foreach ($request->assesments as $assesment) {
            StudentQuiz::create([
                'class_id' => $request->class_id,
                'teacher_id' => $request->teacher_id,
                'quiz_id' => $request->quiz_id,
                'student_id' => $assesment['student_id'],
                'quiz_status' => $assesment['quiz_status'],
                'mark' => $assesment['mark'],
                'comments'  => $assesment['comments']
            ]);
        }

        toastr()->success('Student quiz assesment submitted successfully.');
        return redirect()->route('quiz-assesment.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentQuiz  $studentQuiz
     * @return \Illuminate\Http\Response
     */
    public function show(StudentQuiz $studentQuiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentQuiz  $studentQuiz
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $studentQuiz = StudentQuiz::find($id);
        return view('quiz.assesment.edit', [
            'classes' => DaClass::where('teacher_id', auth()->user()->id)
                         ->where('status', 1)
                         ->get(),
            'quizzes' => Quiz::all(),
            'assesment' => $studentQuiz,
            'students' => Student::where('class_id', $studentQuiz->class_id)
                          ->where('status', 1)->get(),
            'selected' => [
                'class_id' => $studentQuiz->class_id,
                'teacher_id' => DaClass::find($studentQuiz->class_id)->teacher_id,
                'quiz_id'  => $studentQuiz->quiz_id,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentQuiz  $studentQuiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $studentQuiz = StudentQuiz::find($id);
        $studentQuiz->update([
            'quiz_status' => $request->quiz_status,
            'mark' => $request->mark,
            'comments'  => $request->comments
        ]);

        toastr()->success('Student quiz assesment submitted successfully.');
        return redirect()->route('quiz-assesment.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentQuiz  $studentQuiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentQuiz $studentQuiz)
    {
        //
    }
}
