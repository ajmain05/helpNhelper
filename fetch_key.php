<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$content = \App\Models\Content::where('type', 'about')->value('description');
file_put_contents('about_key.txt', $content);
echo "Saved " . strlen($content) . " bytes to about_key.txt";
