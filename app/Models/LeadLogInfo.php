<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadLogInfo extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'loginfo_tbl';

    public $timestamps = false;

    protected $fillable = [
        'log_id',
        'name',
        'shortname',
        'mobile',
        'email',
        'user_types',
        'is_admin',
        'ip_address',
        'status',
        'eterprise_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_date'
    ];
}
