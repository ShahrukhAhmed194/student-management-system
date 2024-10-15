<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trial_class_id',
        'gender',
        'phone',
        'address',
        'due_grace',
        'due_for_months',
        'admitted_on',
        'admitted_by',
        'terminated_on',
        'terminated_by',
        'on_hold_since',
        'on_hold_by',
        'graduated_on',
        'graduated_by',
        'deleted_on',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];
    
    const  PAYMENT_STATUS_PAID = 'Paid';
    const  PAYMENT_STATUS_PENDING = 'Pending';
    
    public function scopeTerminated($query): void
    {
        $query->where('status', 0);
    }
    
    public function scopeAdmitted($query): void
    {
        $query->where('status', 1);
    }
    
    public function scopeGraduated($query): void
    {
        $query->where('status', 2);
    }
    
    public function scopeOnHold($query): void
    {
        $query->where('status', 3);
    }
    
    public function scopeDeleted($query): void
    {
        $query->where('status', 4);
    }
    
    public function scopeNotDeleted($query): void
    {
        $query->where('status', '!=', 4);
    }
    
    public function scopePaymentPaid($query): void
    {
        $query->where('payment_status', self::PAYMENT_STATUS_PAID);
    }
    
    public function scopePaymentPending($query): void
    {
        $query->where('payment_status', self::PAYMENT_STATUS_PENDING);
    }
    
    public function scopePaymentNotNull($query): void
    {
        $query->where('payment_status', '!=', null);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function class()
    {
        return $this->belongsTo(DaClass::class, 'class_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\User', 'parent_id');
    }

    public function parentInfo(): BelongsTo
    {
        return $this->belongsTo(StudentsParent::class, 'parent_id', 'user_id');
    }

    public function admittedBy()
    {
        return $this->belongsTo('App\Models\User', 'admitted_by');
    }

    public function terminatedBy()
    {
        return $this->belongsTo('App\Models\User', 'terminated_by');
    }

    public function graduatedBy()
    {
        return $this->belongsTo('App\Models\User', 'graduated_by');
    }

    public function onHoldBy()
    {
        return $this->belongsTo('App\Models\User', 'on_hold_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo('App\Models\User', 'deleted_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }
    
    public function track_levels(): HasMany
    {
        return $this->hasMany(StudentTrackLevel::class, 'student_id', 'id');
    }
    
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'student_id', 'id');
    }
    
    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class, 'student_id', 'id')->ofMany(
            ['id' => 'max'],
            function ($query) {
                $query
                    ->where('transaction_purpose', '!=', 'robotics-kit')
                ;
            }
        );
    }
    
    
}
