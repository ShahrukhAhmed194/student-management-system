<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomConfig extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql2';
    protected $table = 'zoomconfig_tbl';
    public $timestamps = false;
    
    protected $fillable = [
        'zoom_api_key',
        'zoom_api_secret',
        'accountid',
        'meeting_password',
        'servertoserver_accesstoken',
        'status',
        'update_at',
    ];
}
