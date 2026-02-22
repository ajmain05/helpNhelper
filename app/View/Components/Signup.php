<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Signup extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(protected $countries = [], protected $divisions = [], protected $districts = [], protected $upazilas = [])
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $tutorials = \App\Models\Content::whereIn('type', [
            \App\Enums\Content\ContentType::SignupTutorialVolunteer->value,
            \App\Enums\Content\ContentType::SignupTutorialSeeker->value,
            \App\Enums\Content\ContentType::SignupTutorialDonor->value,
            \App\Enums\Content\ContentType::SignupTutorialCorporateDonor->value,
            \App\Enums\Content\ContentType::SignupTutorialOrganization->value,
        ])->get()->pluck('embed', 'type');

        return view('v2.web.components.signup', [
            'countries' => $this->countries,
            'divisions' => $this->divisions,
            'districts' => $this->districts,
            'upazilas' => $this->upazilas,
            'tutorials' => $tutorials
        ]);
    }
}
