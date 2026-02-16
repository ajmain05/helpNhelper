<?php

namespace App\Http\Controllers\Admin\Content;

use App\Enums\Content\ContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Traits\HasFiles;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use HasFiles;

    public function index()
    {
        $heroSection = Content::whereIn('type',
            [
                ContentType::HomeHero->value,
                ContentType::HomeHeroFooterOne->value,
                ContentType::HomeHeroFooterTwo->value,
                ContentType::HomeHeroFooterThree->value,
                ContentType::HomeHeroFooterFour->value,
            ]
        )->get()->keyBy('type');

        return view('v1.admin.pages.contents.home.index', compact('heroSection'));
    }

    public function heroSectionStore(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'background_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:512'],

            'footer_one_title' => ['nullable', 'string'],
            'footer_one_description' => ['nullable', 'string'],

            'footer_two_title' => ['nullable', 'string'],
            'footer_two_description' => ['nullable', 'string'],

            'footer_three_title' => ['nullable', 'string'],
            'footer_three_description' => ['nullable', 'string'],

            'footer_four_title' => ['nullable', 'string'],
            'footer_four_description' => ['nullable', 'string'],
        ]);

        $hero = Content::firstOrCreate([
            'type' => ContentType::HomeHero->value,
        ]);
        $hero->title = $request->title ?? null;
        $hero->description = $request->description ?? null;
        if (isset($request->background_image)) {
            $this->removeFile($hero->background_image);

            $image = $this->storeFile('content/home', $request->background_image, 'about');
            $hero->background_image = $image;
        }
        $hero->save();

        Content::updateOrCreate(
            [
                'type' => ContentType::HomeHeroFooterOne->value,
            ],
            [
                'title' => $request->footer_one_title ?? null,
                'description' => $request->footer_one_description ?? null,
            ]
        );

        Content::updateOrCreate(
            [
                'type' => ContentType::HomeHeroFooterTwo->value,
            ],
            [
                'title' => $request->footer_two_title ?? null,
                'description' => $request->footer_two_description ?? null,
            ]
        );

        Content::updateOrCreate(
            [
                'type' => ContentType::HomeHeroFooterThree->value,
            ],
            [
                'title' => $request->footer_three_title ?? null,
                'description' => $request->footer_three_description ?? null,
            ]
        );

        Content::updateOrCreate(
            [
                'type' => ContentType::HomeHeroFooterFour->value,
            ],
            [
                'title' => $request->footer_four_title ?? null,
                'description' => $request->footer_four_description ?? null,
            ]
        );

        return redirect()->back()->with('success', 'Home hero content updated successfully.');
    }
}
