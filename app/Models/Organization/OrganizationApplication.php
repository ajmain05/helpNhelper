<?php

namespace App\Models\Organization;

use App\Enums\Organization\OrganizationApplicationFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class OrganizationApplication extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'sid',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(OrganizationApplicationFile::AUTH_FILE->value)->singleFile();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function volunteers()
    {
        return $this->hasManyThrough(User::class, OrganizationApplicationVolunteer::class, secondKey: 'id', secondLocalKey: 'user_id');
    }

    protected static function booted()
    {
        static::created(function ($organizationApplication) {
            $organizationApplication->sid = 'OAT-'. 100_000 + $organizationApplication->id;
            $organizationApplication->save();
        });
    }
}
