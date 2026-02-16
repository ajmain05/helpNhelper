<?php

namespace App\Enums\Seeker;

use App\Traits\Enumerrayble;

enum SeekerApplicationCategory: string
{
    use Enumerrayble;

    case Food = 'food';
    case Health = 'health';
    case Housing = 'housing';
    case Water = 'water';
    case Sanitation = 'sanitation';
    case Education = 'education';
    case KarjEHasana = 'karj-e-hasana';
    case WinterCloth = 'winter-cloth';
    case Others = 'others';

}
