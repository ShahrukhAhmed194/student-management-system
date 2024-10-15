<?php

namespace App\Models\CertificateModule;

use App\Models\CourseLevel;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'student_id',
        'level_id',
        'created_by',
    ];
    
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    
    public function level(): BelongsTo
    {
        return $this->belongsTo(CourseLevel::class, 'level_id');
    }
    
    public function created_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
}
