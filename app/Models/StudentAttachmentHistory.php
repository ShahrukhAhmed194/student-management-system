<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttachmentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'user_id',
        'notes',
        'attachment',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
