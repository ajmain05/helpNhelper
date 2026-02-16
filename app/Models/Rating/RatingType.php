<?php

namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'highest_score',
        'remarks',
    ];
}
