<?php

namespace App\Models\Organization;

use App\Enums\Organization\OrganizationApplicationFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class OrganizationApplication extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'sid',
        'title',
        'description',
        'category',
        'requested_amount',
        'collected_amount',
        'seeker_name',
        'seeker_location',
        'payment_method',
        'payment_account',
        'cert_image',
        'status',
        'service_charge_pct',
        'net_amount_payable',
        'assigned_volunteer_id',
        'approved_by',
        'rejection_reason',
        'completion_date',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(OrganizationApplicationFile::AUTH_FILE->value)->singleFile();
    }

    public function organization()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedVolunteer()
    {
        return $this->belongsTo(User::class, 'assigned_volunteer_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getProgressAttribute()
    {
        if ($this->requested_amount <= 0) {
            return 0;
        }
        $pct = ($this->collected_amount / $this->requested_amount) * 100;

        return min(max($pct, 0), 100);
    }

    protected static function booted()
    {
        static::created(function ($organizationApplication) {
            $organizationApplication->sid = 'OAT-'. 100_000 + $organizationApplication->id;
            $organizationApplication->save();
        });
    }
}
