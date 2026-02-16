<?php

namespace App\Models\Seeker;

use App\Enums\Seeker\SeekerApplicationFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SeekerApplication extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'seeker_applications';

    protected $fillable = [
        'sid',
        'user_id',
        'title',
        'description',
        'volunteer_document',
        'requested_amount',
        'completion_date',
        'status',
        'category',
        'document',
        'image',
        'comment',
    ];

    //register media collection
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(SeekerApplicationFile::AUTH_FILE->value)->singleFile();
    }

    //relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function volunteers()
    {
        return $this->hasManyThrough(User::class, SeekerApplicationVolunteer::class, secondKey: 'id', secondLocalKey: 'user_id');
    }

    protected static function booted()
    {
    }

    public function getTranslation($field)
    {
        $locale = app()->getLocale();
        if ($locale == 'en') {
            return $this->$field;
        }
        $localizedField = $field . '_' . $locale;
        return $this->$localizedField ?? $this->$field;
    }
}
