<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'teacher_id',
        'day',
        'time'
    ];

    public function class()
    {
        return $this->belongsTo(DaClass::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\User', 'teacher_id');
    }
}
