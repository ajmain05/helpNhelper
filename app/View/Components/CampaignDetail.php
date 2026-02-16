<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CampaignDetail extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(protected $campaign = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('v2.web.components.campaign-detail', ['campaign' => $this->campaign]);
    }
}
