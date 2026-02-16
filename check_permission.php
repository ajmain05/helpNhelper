<?php

use App\Models\User;
use Illuminate\Support\Facades\Gate;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'su@coderslab.com.bd';
$user = User::where('email', $email)->first();

if ($user) {
    echo "User: " . $user->name . "\n";
    echo "Roles: " . implode(', ', $user->getRoleNames()->toArray()) . "\n";
    
    $permission = 'admin-dashboard';
    echo "Checking permission: {$permission}\n";
    
    if ($user->can($permission)) {
        echo "✅ User HAS {$permission} permission.\n";
    } else {
        echo "❌ User DOES NOT HAVE {$permission} permission.\n";
    }
} else {
    echo "User not found.\n";
}
