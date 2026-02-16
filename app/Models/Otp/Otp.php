<?php

namespace App\Models\Otp;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['contact_type', 'contact', 'otp', 'purpose', 'created_at', 'expires_at', 'used_at'];

    public function user()
    {
        if ($this->contact_type == 'mobile') {
            return $this->belongsTo(User::class, 'contact', 'mobile');
        }

        return $this->belongsTo(User::class, 'contact', 'email');
    }
}
