<?php

namespace App\Models\Campaign;

use App\Enums\Campaign\CampaignFile;
use App\Models\Donation;
use App\Models\Invoice\Invoice;
use App\Models\Seeker\SeekerApplication;
use App\Models\SuccessStory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Campaign extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    //register media collection
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(CampaignFile::IMAGES->value);
    }

    //relations
    public function seeker_application()
    {
        return $this->belongsTo(SeekerApplication::class, 'seeker_application_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(CampaignCategory::class, 'category_id', 'id');
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->format('d M, Y');
    // }

    protected function photo(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset($value),
        );
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'campaign_id', 'id');
    }

    public function donors(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function successStory(): HasMany
    {
        return $this->hasMany(SuccessStory::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(CampaignImage::class);
    }

    protected static function booted()
    {
        static::created(function ($campaign) {
            $campaign->sid = 'CT-'. 100_000 + $campaign->id;
            $campaign->save();
        });
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
