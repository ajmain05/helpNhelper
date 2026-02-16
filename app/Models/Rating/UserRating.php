<?php

namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRating extends Model
{
    use HasFactory;

    protected $fillable = ['rating_type_id', 'score', 'user_id', 'month_year'];

    public function ratingType()
    {
        return $this->belongsTo(RatingType::class);
    }
}
