<?php

namespace App\Models;

use App\Models\Otp\Otp;
use App\Models\Rating\UserRating;
use App\Models\Seeker\Seeker;
use App\Models\User\UserBank;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanResetPassword, MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'country_id',
        'division_id',
        'district_id',
        'permanent_address',
        'present_address',
        'donor_category_id',
        'type',
        'status',
        'sid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function upazila()
    {
        return $this->belongsTo(Upazila::class);
    }

    // public function seeker()
    // {
    //     return $this->hasMany(Seeker::class);
    // }

    public function otps($contactType)
    {
        if ($contactType == 'mobile') {
            return $this->hasMany(Otp::class, 'contact', 'mobile');
        }

        return $this->hasMany(Otp::class, 'contact', 'email');
    }

    public function userBanks()
    {
        return $this->hasMany(UserBank::class);
    }

    public function ratings()
    {
        return $this->hasMany(UserRating::class);
    }
}
