<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeroSection extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(protected $type = 1, protected $title = 'Welcome', protected $bgImage = null, protected $campaign = null, protected $contents = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('v2.web.components.hero-section', ['type' => $this->type, 'title' => $this->title, 'bgImage' => $this->bgImage, 'campaign' => $this->campaign, 'contents' => $this->contents]);
    }
}
