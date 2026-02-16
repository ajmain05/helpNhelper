<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MarqueeText extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(protected $keywords = ['Support', 'Help', 'Love'], protected $length = 1, protected $type = 1)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('v2.web.components.marquee-text', ['keywords' => $this->keywords, 'length' => $this->length, 'type' => $this->type]);
    }
}
