<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FeaturedCollection extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(protected $campaigns = null, protected $type = 1)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('v2.web.components.featured-collection', ['campaigns' => $this->campaigns, 'type' => $this->type]);
    }
}
