<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

app()->setLocale('bn');
$t = \App\Models\Content::where('type', 'about')->value('description');
echo "Locale: " . app()->getLocale() . "\n";
echo "Content Length: " . strlen($t) . "\n";
$translated = __($t);

if ($translated === $t) {
    echo "Translation FAILED (Returned same string)\n";
} else {
    echo "Translation SUCCESS\n";
    echo substr($translated, 0, 100) . "...\n";
}
