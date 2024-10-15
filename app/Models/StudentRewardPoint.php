<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRewardPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'points',
    ];

     public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }

    public function studentInfo(){
        return $this->belongsTo(Student::class, 'student_id');
    }
}
