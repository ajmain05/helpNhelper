<?php

namespace App\Models;

use App\Models\Campaign\Campaign;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessStory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
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

    protected function previousCondition(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset($value),
        );
    }

    protected function presentCondition(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset($value),
        );
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
