<?php

use App\Models\Campaign\Campaign;
use App\Models\Campaign\CampaignImage;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$campaignCount = Campaign::count();
$latestCampaign = Campaign::with('images')->latest()->first();
$imageCount = $latestCampaign ? $latestCampaign->images->count() : 0;
$totalImages = CampaignImage::count();

echo "Total Campaigns: " . $campaignCount . "\n";
if ($latestCampaign) {
    echo "Latest Campaign ID: " . $latestCampaign->id . "\n";
    echo "Latest Campaign Images: " . $imageCount . "\n";
}
echo "Total Campaign Images in DB: " . $totalImages . "\n";
