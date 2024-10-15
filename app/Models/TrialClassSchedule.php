<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialClassSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'age_from',
        'age_to',
        'country',
        'date',
        'time',
        'teacher_id',
        'coordinator_id',
        'status',
        'available_seats'
    ];

    public function teacher()
    {
        return $this->belongsTo('App\Models\User', 'teacher_id');
    }
    
    public function coordinator()
    {
        return $this->belongsTo('App\Models\User', 'coordinator_id');
    }

    public function students()
    {
        return $this->hasMany(TrialClass::class, 'trial_class_id', 'id');
    }
}
