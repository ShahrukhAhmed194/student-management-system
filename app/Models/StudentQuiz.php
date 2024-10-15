<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'teacher_id',
        'quiz_id',
        'student_id',
        'quiz_status',
        'mark',
        'comments'
    ];

    public function class()
    {
        return $this->belongsTo(DaClass::class, 'class_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
