<?php

namespace Database\Seeders;

use App\Http\Traits\UserTrait;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    use UserTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::updateOrCreate(['name' => $this->super_admin_role], ['name' => $this->super_admin_role]);
        $donor = Role::updateOrCreate(['name' => $this->donor_role], ['name' => $this->donor_role]);
        $volunteer = Role::updateOrCreate(['name' => $this->volunteer_role], ['name' => $this->volunteer_role]);
        $seeker = Role::updateOrCreate(['name' => $this->seeker_role], ['name' => $this->seeker_role]);
        $organization = Role::updateOrCreate(['name' => $this->organization_role], ['name' => $this->organization_role]);
        $permissions = Permission::all();
        $superAdmin = Role::where('name', $this->super_admin_role)->first();
        $superAdmin->syncPermissions($permissions);
    }
}
