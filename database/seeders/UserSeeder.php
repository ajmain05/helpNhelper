<?php

namespace Database\Seeders;

use App\Enums\User\Status;
use App\Enums\User\Type;
use App\Http\Traits\UserTrait;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use UserTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin_user = User::firstOrCreate(
            ['email' => 'su@coderslab.com.bd'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'type' => Type::SuperAdmin->value,
                'status' => Status::Approved->value,
            ]
        );
        $super_admin_user->assignRole($this->super_admin_role);
    }
}
