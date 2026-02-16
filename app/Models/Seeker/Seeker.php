<?php

namespace App\Models\Seeker;

use App\Enums\Seeker\SeekerFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Seeker extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    //register media collection
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(SeekerFile::AUTH_FILE->value)->singleFile();
        $this->addMediaCollection(SeekerFile::PROFILE_IMG->value)->singleFile();
    }

    //relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
