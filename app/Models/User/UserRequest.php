<?php

namespace App\Models\User;

use App\Enums\User\UserRequestFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UserRequest extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    //register media collection
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(UserRequestFile::PROFILE_IMG->value)->singleFile();
        $this->addMediaCollection(UserRequestFile::AUTH_FILE->value)->singleFile();
    }
}
