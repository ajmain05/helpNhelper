<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'target_amount',
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
    ];

    /**
     * Get the organization user who created the application.
     */
    public function organization()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the volunteer assigned to investigate/manage this application.
     */
    public function assignedVolunteer()
    {
        return $this->belongsTo(User::class, 'assigned_volunteer_id');
    }

    /**
     * Get the admin user who approved this application.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Accessor to get progress percentage
     */
    public function getProgressAttribute()
    {
        if ($this->target_amount <= 0) {
            return 0;
        }
        $pct = ($this->collected_amount / $this->target_amount) * 100;
        return min(max($pct, 0), 100);
    }
}
