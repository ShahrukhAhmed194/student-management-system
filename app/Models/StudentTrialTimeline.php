<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTrialTimeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'trial_class_id',
        'registration_complete',
        'registration_complete_date',
        'registration_complete_time',
        'will_attend',
        'will_attend_date',
        'will_attend_time',
        'rescheduled',
        'rescheduled_date',
        'rescheduled_time',
        'attended',
        'attended_date',
        'attended_time',
        'refused_admission',
        'refused_admission_date',
        'refused_admission_time',
        'payment_complete',
        'payment_complete_date',
        'payment_complete_time',
        'admission_complete',
        'admission_complete_date',
        'admission_complete_time',
    ];

    
    public function trialClass()
    {
        return $this->belongsTo(TrialClass::class, 'trial_class_id');
    }
}
