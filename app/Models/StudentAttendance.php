<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'teacher_id',
        'date',
        'student_id',
        'status',
        'comments'
    ];


    public function class()
    {
        return $this->belongsTo(DaClass::class, 'class_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function studentInfo()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
