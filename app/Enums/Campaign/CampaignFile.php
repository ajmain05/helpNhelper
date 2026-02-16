<?php

namespace App\Enums\Campaign;

use App\Traits\Enumerrayble;

enum CampaignFile: string
{
    use Enumerrayble;

    case IMAGES = 'campaign_images';

}
