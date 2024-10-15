<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempSessionRecord extends Model
{
    use HasFactory;
    
    protected static function booted(): void
    {
        static::addGlobalScope('not_deleted', function(Builder $builder) {
            $builder->where('is_delete', false);
        });
    }
    
    protected $fillable = [
        'class_session_id',
        'uuid',
        'meeting_id',
        'is_delete',
    ];
}
