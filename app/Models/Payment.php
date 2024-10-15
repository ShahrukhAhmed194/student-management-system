<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    protected static function booted(): void
    {
        static::addGlobalScope('not_deleted', function(Builder $builder) {
            $builder->where('is_delete', false);
        });
    }

    protected $fillable = [
        'student_id',
        'fees',
        'date',
        'transaction_type',
        'transaction_id',
        'transaction_purpose',
        'notes',
        'payment_status',
        'send_confirmation',
        'status',
        'agreement',
        'invoice_sent',
        'for_month'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
