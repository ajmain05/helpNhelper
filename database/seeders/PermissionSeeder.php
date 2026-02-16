<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET foreign_key_checks=0');
        Permission::truncate();
        DB::statement('SET foreign_key_checks=1');
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            ['name' => 'admin-dashboard'],

            ['name' => 'all-user'],
            ['name' => 'create-user'],
            ['name' => 'edit-user'],
            ['name' => 'delete-user'],

            ['name' => 'all-user-request'],
            ['name' => 'edit-user-request'],
            ['name' => 'delete-user-request'],

            ['name' => 'all-role'],
            ['name' => 'create-role'],
            ['name' => 'edit-role'],
            ['name' => 'delete-role'],

            ['name' => 'all-seeker'],
            ['name' => 'create-seeker'],
            ['name' => 'edit-seeker'],
            ['name' => 'delete-seeker'],

            ['name' => 'all-volunteer'],
            ['name' => 'create-volunteer'],
            ['name' => 'edit-volunteer'],
            ['name' => 'delete-volunteer'],

            ['name' => 'all-donor'],
            ['name' => 'create-donor'],
            ['name' => 'edit-donor'],
            ['name' => 'delete-donor'],

            ['name' => 'all-seeker-application'],
            ['name' => 'create-seeker-application'],
            ['name' => 'edit-seeker-application'],
            ['name' => 'delete-seeker-application'],

            ['name' => 'all-campaign-category'],
            ['name' => 'create-campaign-category'],
            ['name' => 'edit-campaign-category'],
            ['name' => 'delete-campaign-category'],

            ['name' => 'all-campaign'],
            ['name' => 'create-campaign'],
            ['name' => 'edit-campaign'],
            ['name' => 'delete-campaign'],

            ['name' => 'all-organization'],
            ['name' => 'create-organization'],
            ['name' => 'edit-organization'],
            ['name' => 'delete-organization'],

            ['name' => 'all-organization-application'],
            ['name' => 'create-organization-application'],
            ['name' => 'edit-organization-application'],
            ['name' => 'delete-organization-application'],

            ['name' => 'all-account'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
