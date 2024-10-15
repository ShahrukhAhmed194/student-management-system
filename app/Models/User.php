<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    
    const USER_TYPE_SUPER_ADMIN = 'Super-Admin';
    const USER_TYPE_ADMIN = 'Admin';
    const USER_TYPE_COORDINATOR = 'Coordinator';
    const USER_TYPE_TEACHER = 'Teacher';
    const USER_TYPE_PARENT = 'Parent';
    const USER_TYPE_STUDENT = 'Student';
    const USER_TYPE_SALES_EXECUTIVE = 'Sales Executive';
    const USER_TYPE_CUSTOMER_SUPPORT_EXECUTIVE = 'Customer Support Executive';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'user_name',
        'email',
        'phone',
        'status',
        'zoom_topic',
        'zoom_meeting_id',
        'zoom_password',
        'password',
        'user_type',
        'value_a',
        'class_login_details',
        'track_ids'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'twitter_profile',
        'facebook_profile',
        'instagram_profile',
        'linkedln_profile',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
