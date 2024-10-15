<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;
    protected $table = 'tokens';

    protected $fillable = [
        'user_id',
        'email',
        'token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
