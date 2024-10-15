<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\NotifyParent;

class TrialClassNotify extends Model
{
    use HasFactory;

    protected $fillable = [
        'trial_class_sch_id',
        'notify_time',
    ];
}
