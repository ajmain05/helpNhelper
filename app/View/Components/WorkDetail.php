<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WorkDetail extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(protected $work = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('v2.web.components.work-detail', ['work' => $this->work]);
    }
}
