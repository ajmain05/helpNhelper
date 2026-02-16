<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StepBar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $step = 1, public $position = 1)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('v2.web.components.step-bar');
    }
}
