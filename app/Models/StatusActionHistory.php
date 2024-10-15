<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusActionHistory extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'trial_class_id',
        'status',
        'date',
    ];
    
    public function trial(){

        return $this->belongsTo(TrialClass::class, 'trial_class_id');
    }

    public function changedBy(){

        return $this->belongsTo(User::class, 'user_id');
    }
}
