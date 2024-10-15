<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'trial_class_id',
        'gurdian_name',
        'phone',
        'email',
        'occupation',
        'country',
        'hasDevice',
        'hear_from',
        'school',
        'student_name',
        'age',
        'gender',
        'payable_amount',
        'sales_user_id',
        'status',
        'language',
        'note',
        'utm_medium'
    ];
    
    const STATUS_INVALID = 'Invalid';
    const STATUS_NOT_INTERESTED = 'Not Interested';
    
    public function scopeValid($query): void
    {
        $query->where('status', '!=', self::STATUS_INVALID);
    }

    public function schedule()
    {
        return $this->belongsTo(TrialClassSchedule::class, 'trial_class_id');
    }

    public function salesTeam()
    {
        return $this->belongsTo(SalesUser::class, 'sales_user_id', 'user_id');
    }
}
