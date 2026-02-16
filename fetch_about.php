<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$content = \App\Models\Content::where('type', 'about')->first();
if ($content) {
    file_put_contents('about_desc.txt', $content->description);
    echo "Description saved to about_desc.txt";
} else {
    echo "No content found";
}
