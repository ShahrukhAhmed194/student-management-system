<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'teacher_id',
        'project_id',
        'student_id',
        'project_status',
        'project_assesment',
        'comments',
        'is_homework'
    ];

    public function class()
    {
        return $this->belongsTo(DaClass::class, 'class_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
