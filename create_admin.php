<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Enums\User\Type;
use App\Enums\User\Status;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'admin@admin.com';
$password = 'password';

$user = User::where('email', $email)->first();

if (!$user) {
    $user = User::create([
        'name' => 'Admin',
        'email' => $email,
        'password' => Hash::make($password),
        'type' => 'super_admin', // Using string directly as enum might need casting
        'status' => 'approved',
    ]);
    echo "User created.\n";
} else {
    $user->password = Hash::make($password);
    $user->save();
    echo "User updated.\n";
}

// Create role if not exists
try {
    $role = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
    $user->assignRole($role);
    echo "Role assigned.\n";
} catch (\Exception $e) {
    echo "Error assigning role: " . $e->getMessage() . "\n";
}
