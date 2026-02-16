<?php
$basePath = 'd:/helpNhelper/helpNhelper-new-design-dev';
$keyFile = $basePath . '/about_key.txt';
$jsonFile = $basePath . '/lang/bn.json';

if (!file_exists($keyFile)) {
    die("Key file not found: $keyFile");
}
if (!file_exists($jsonFile)) {
    die("JSON file not found: $jsonFile");
}

$key = file_get_contents($keyFile);
// Trim key to match what might be happening? No, about-us.blade.php uses raw $description.
// But database values often have no trailing newline, while file_put_contents might add one?
// Let's check the length.
echo "Key length: " . strlen($key) . "\n";

$jsonContent = file_get_contents($jsonFile);
$json = json_decode($jsonContent, true);

if ($json === null) {
    die("JSON decode failed: " . json_last_error_msg());
}

// Add the key
$json[$key] = "আমাদের সম্পর্কে বিস্তারিত (এখানে আপনার অনুবাদ দিন)... [Note: This translation key connects to the database content. Modify this value in bn.json]";

$newJsonContent = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

if ($newJsonContent === false) {
    die("JSON encode failed: " . json_last_error_msg());
}

if (file_put_contents($jsonFile, $newJsonContent) === false) {
    die("Failed to write to $jsonFile");
}

echo "Successfully added key to bn.json. Total keys: " . count($json) . "\n";
