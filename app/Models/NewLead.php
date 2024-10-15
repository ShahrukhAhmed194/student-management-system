<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewLead extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'students_tbl';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'name',
        'mobile',
        'email',
        'address',
        'biography',
        'country',
        'city',
        'state',
        'zipcode',
        'enterprise_id',
        'status',
        'created_by',
        'updated_by',

    ];
}
