<?php

use Illuminate\Support\Facades\App;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Current Locale: " . App::getLocale() . "\n";
echo "Home (Default): " . __('Home') . "\n";

App::setLocale('bn');
echo "Set Locale to: bn\n";
echo "Home (BN): " . __('Home') . "\n";

$jsonPath = base_path('lang/bn.json');
echo "JSON Path: $jsonPath\n";
if (file_exists($jsonPath)) {
    echo "JSON File Exists.\n";
    echo "Content: " . file_get_contents($jsonPath) . "\n";
} else {
    echo "JSON File Missing!\n";
}
