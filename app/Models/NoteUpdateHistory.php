<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteUpdateHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'trial_class_id',
        'note',
        'user_id',
    ];
    
    public function trialClass(){

        return $this->belongsTo(TrialClass::class, 'trial_class_id');
    }

    public function stenographer(){

        return $this->belongsTo(User::class, 'user_id');
    }
}
