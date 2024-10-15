<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentNoteHistories extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'note',
        'submitter_id',
    ];

    public function stenographer(){

        return $this->belongsTo(User::class, 'submitter_id');
    }
}
