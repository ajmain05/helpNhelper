<?php

namespace App\Models\Donor;

use App\Enums\Donor\DonorFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Donor extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    //register media collection
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(DonorFile::AUTH_FILE->value)->singleFile();
        $this->addMediaCollection(DonorFile::PROFILE_IMG->value)->singleFile();
    }

    //relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
