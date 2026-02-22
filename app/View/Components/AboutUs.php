<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AboutUs extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $title = null,
        public $title_bn = null,
        public $title_ar = null,
        public $description = null,
        public $description_bn = null,
        public $description_ar = null,
        public $image1 = null,
        public $image2 = null
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('v2.web.components.about-us');
    }
}
