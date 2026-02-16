<?php

use App\Models\User;
use Illuminate\Support\Carbon;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'su@coderslab.com.bd';
$user = User::where('email', $email)->first();

if ($user) {
    $user->email_verified_at = Carbon::now();
    $user->save();
    echo "User {$email} verified successfully.\n";
} else {
    echo "User {$email} not found.\n";
}
