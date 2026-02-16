<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$dbContent = \App\Models\Content::where('type', 'about')->value('description');
$json = json_decode(file_get_contents('lang/bn.json'), true);
$jsonKey = array_key_last($json); 

echo "DB Content MD5: " . md5($dbContent) . "\n";
echo "JSON Key MD5:   " . md5($jsonKey) . "\n";
echo "DB Length: " . strlen($dbContent) . "\n";
echo "JSON Key Length: " . strlen($jsonKey) . "\n";

if (md5($dbContent) === md5($jsonKey)) {
    echo "MATCH!\n";
} else {
    echo "MISMATCH!\n";
    // Show first difference
    for ($i = 0; $i < min(strlen($dbContent), strlen($jsonKey)); $i++) {
        if ($dbContent[$i] !== $jsonKey[$i]) {
            echo "First mismatch at index $i. DB: " . ord($dbContent[$i]) . ", JSON: " . ord($jsonKey[$i]) . "\n";
            break;
        }
    }
}
