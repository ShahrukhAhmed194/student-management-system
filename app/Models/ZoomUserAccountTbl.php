<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomUserAccountTbl extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql2';
    protected $table = 'zoom_useraccount_tbl';
    public $timestamps = false;
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'topic',
        'meeting_id',
        'password',
        'zoom_ac_id',
        'is_active',
        'created_date'
    ];
}