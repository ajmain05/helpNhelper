<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'su@coderslab.com.bd';
$user = User::where('email', $email)->first();

if ($user) {
    // Determine the correct role name from UserTrait or DB
    // Assuming 'super-admin' based on previous findings
    $roleName = 'super-admin';
    $role = Role::where('name', $roleName)->first();

    if ($role) {
        // assignRole adds the role, syncRoles replaces all roles with this one
        $user->syncRoles($role);
        echo "User {$email} assigned role {$roleName}.\n";
        
        // Also verify permissions on the role
        $permissionCount = $role->permissions()->count();
        echo "Role {$roleName} has {$permissionCount} permissions.\n";
        
        if ($permissionCount == 0) {
             echo "Warning: Role has no permissions! seeding permissions...\n";
             // Basic permission seeding if missing
             $permissions = Permission::all();
             $role->syncPermissions($permissions);
             echo "Synced " . $permissions->count() . " permissions to role.\n";
        }

    } else {
        echo "Role {$roleName} not found.\n";
    }
} else {
    echo "User {$email} not found.\n";
}
