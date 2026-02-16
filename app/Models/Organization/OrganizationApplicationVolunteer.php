<?php

namespace App\Models\Organization;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationApplicationVolunteer extends Model
{
    use HasFactory;

    protected $table = 'organ_appli_volunteers';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function application()
    {
        return $this->belongsTo(OrganizationApplication::class, 'organization_application_id', 'id');
    }
}
