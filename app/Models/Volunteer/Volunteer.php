<?php

namespace App\Models\Volunteer;

use App\Enums\Volunteer\VolunteerFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Volunteer extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    //register media collection
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(VolunteerFile::AUTH_FILE->value)->singleFile();
        $this->addMediaCollection(VolunteerFile::PROFILE_IMG->value)->singleFile();
    }

    //relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
