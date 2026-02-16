<?php

namespace App\Http\Controllers\Api;

use App\Enums\Content\ContentType;
use App\Http\Controllers\Controller;
use App\Models\About\MeetOurTeam;
use App\Models\Content;
use App\Models\Country;
use App\Models\District;
use App\Models\Division;
use App\Models\Faq;
use App\Models\Upazila;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ContentController extends Controller
{
    public function contents(Request $request)
    {
        $types = collect(explode(',', $request->types))
            ->map(fn ($type) => trim($type))
            ->filter()
            ->values();

        $invalidTypes = $types->filter(fn ($type) => ! ContentType::tryFrom($type));

        if ($invalidTypes->isNotEmpty()) {
            throw ValidationException::withMessages([
                'types' => ['Invalid types: '.$invalidTypes->implode(', ')],
            ]);
        }

        $contents = Content::whereIn('type', $types)->get();

        return response()->json(['data' => $contents], Response::HTTP_OK);
    }

    public function faq()
    {
        $faq = Faq::latest()->get();

        return response()->json(['data' => $faq], Response::HTTP_OK);
    }

    public function meetOurTeam()
    {
        $teams = MeetOurTeam::oldest('sequence')->get();

        return response()->json(['data' => $teams], Response::HTTP_OK);
    }

    public function country()
    {
        $country = Country::orderBy('name')->get();

        return response()->json(['data' => $country], Response::HTTP_OK);
    }

    public function division(Request $request)
    {
        $country_id = $request->query('country_id', null);

        $divisions = Division::when($country_id !== null, function ($q) use ($country_id) {
            $q->where('country_id', $country_id);
        })->get();

        return response()->json(['data' => $divisions], Response::HTTP_OK);
    }

    public function district(Request $request)
    {
        $division_id = $request->query('division_id', null);

        $districts = District::when($division_id !== null, function ($q) use ($division_id) {
            $q->where('division_id', $division_id);
        })->get();

        return response()->json(['data' => $districts], Response::HTTP_OK);
    }

    public function upazila(Request $request)
    {
        $district_id = $request->query('district_id', null);

        $upazila = Upazila::when($district_id !== null, function ($q) use ($district_id) {
            $q->where('district_id', $district_id);
        })->get();

        return response()->json(['data' => $upazila], Response::HTTP_OK);
    }
}
