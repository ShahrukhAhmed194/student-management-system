<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClassParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'class_session_id',
    ];

    public function classSession()
    {
        return $this->belongsTo(ClassSession::class, 'class_session_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'id');
    }
}
