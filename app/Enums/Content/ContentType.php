<?php

namespace App\Enums\Content;

use App\Traits\Enumerrayble;

enum ContentType: string
{
    use Enumerrayble;
    // home page
    case HomeHero = 'home-hero';
    case HomeHeroFooterOne = 'home-hero-footer-one';
    case HomeHeroFooterTwo = 'home-hero-footer-two';
    case HomeHeroFooterThree = 'home-hero-footer-three';
    case HomeHeroFooterFour = 'home-hero-footer-four';

    // about use page
    case About = 'about';

}
