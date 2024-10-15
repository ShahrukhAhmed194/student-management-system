<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentTrackLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'track_id',
        'level_id',
        'start_date',
        'completion_date',
    ];
    
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    
    public function track(): BelongsTo
    {
        return $this->belongsTo(CourseTrack::class, 'track_id');
    }
    
    public function level(): BelongsTo
    {
        return $this->belongsTo(CourseLevel::class, 'level_id');
    }
    
}
