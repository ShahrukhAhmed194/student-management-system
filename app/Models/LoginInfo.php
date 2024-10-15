<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'browser_agent',
        'login_date',
        'login_time',
        'logout_date',
        'logout_time',
    ];
}
