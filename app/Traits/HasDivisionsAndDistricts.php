<?php

namespace App\Traits;

use App\Models\Country;
use App\Models\District;
use App\Models\Division;
use App\Models\Upazila;

trait HasDivisionsAndDistricts
{
    private function getCountriesDivisionsDistrictsUpazilas()
    {
        $countries = Country::orderBy('name')->get();
        $divisions = Division::orderBy('name')->get();
        $districts = District::orderBy('name')->get();
        $upazilas = Upazila::orderBy('name')->get();

        return compact(['countries', 'divisions', 'districts', 'upazilas']);
    }
}
