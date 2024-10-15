<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'learning_outcomes',
        'link_teacher',
        'link_student_before',
        'link_student_after',
        'course_id',
        'track_id',
        'level_id',
        'is_homework',
        'notes',
    ];
}
