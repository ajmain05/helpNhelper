<?php

namespace App\Models\Campaign;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignCategory extends Model
{
    use HasFactory;

    protected $table = 'campaign_categories';

    protected $fillable = [
        'title',
        'title_bn',
        'title_ar',
    ];

    //relations
    public function parent_category()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'category_id', 'id');
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
