<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialClassCallHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'trial_class_id',
        'user_id',
        'phone'
    ];

    public function trialClass()
    {
        return $this->belongsTo(TrialClass::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
