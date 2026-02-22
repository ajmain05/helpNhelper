<?php

namespace App\Http\Controllers\Admin\Content;

use App\Enums\Content\ContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Traits\HasFiles;
use Illuminate\Http\Request;

class SignupTutorialController extends Controller
{
    use HasFiles;

    public function index()
    {
        $types = [
            ContentType::SignupTutorialVolunteer->value => 'Volunteer Tutorial',
            ContentType::SignupTutorialSeeker->value => 'Seeker Tutorial',
            ContentType::SignupTutorialDonor->value => 'Donor Tutorial',
            ContentType::SignupTutorialCorporateDonor->value => 'Corporate Donor Tutorial',
            ContentType::SignupTutorialOrganization->value => 'Organization Tutorial',
        ];

        $contents = Content::whereIn('type', array_keys($types))->get()->keyBy('type');

        return view('v1.admin.pages.contents.signup-tutorials.index', compact('types', 'contents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', 'string'],
            'pdf_file' => ['required', 'file', 'mimes:pdf', 'max:5120'], // 5MB limit
        ]);

        $content = Content::firstOrCreate([
            'type' => $request->type,
        ]);

        if ($request->hasFile('pdf_file')) {
            if ($content->embed) {
                $this->removeFile($content->embed);
            }

            $filePath = $this->storeFile('content/tutorials', $request->file('pdf_file'), 'tutorial');
            $content->embed = $filePath;
            $content->save();
        }

        return back()->with('success', 'Tutorial PDF updated successfully.');
    }
}
