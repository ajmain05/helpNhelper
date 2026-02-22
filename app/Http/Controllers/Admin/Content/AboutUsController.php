<?php

namespace App\Http\Controllers\Admin\Content;

use App\Enums\Content\ContentType;
use App\Http\Controllers\Controller;
use App\Models\About\MeetOurTeam;
use App\Models\Content;
use App\Traits\HasFiles;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AboutUsController extends Controller
{
    use HasFiles;

    public function index()
    {
        $teams = MeetOurTeam::where('type', 'team')->oldest('sequence')->get();
        $shariah = MeetOurTeam::where('type', 'shariah')->oldest('sequence')->get();
        $about = Content::where('type', 'about')->first();

        return view('v1.admin.pages.contents.about-us.index', compact('teams', 'shariah', 'about'));
    }

    public function aboutContentStore(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_bn' => ['nullable', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'description_bn' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'image_1' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $about = Content::firstOrCreate([
            'type' => ContentType::About->value,
        ]);

        $about->title = $request->title;
        $about->title_bn = $request->title_bn;
        $about->title_ar = $request->title_ar;
        $about->description = $request->description;
        $about->description_bn = $request->description_bn;
        $about->description_ar = $request->description_ar;
        if (isset($request->image_1)) {
            $this->removeFile($about->image_1);

            $image = $this->storeFile('content/about-us', $request->image_1, 'about');
            $about->image_1 = $image;
        }
        $about->save();

        return redirect()->to('admin/contents/about-us')->with('success', 'About us content updated successfully.');
    }

    public function teamStore(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:556'],
            'designation' => ['required', 'string', 'max:556'],
            'institution' => ['required', 'string', 'max:556'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:1024'],
            'sequence' => ['required', 'integer', 'min:0'],
            'type' => ['required', 'in:team,shariah'],
        ]);

        if (isset($request->image)) {
            $image = $this->storeFile('content/about-us', $request->image, 'team');
            $data['image'] = $image;
        }
        MeetOurTeam::create($data);

        return redirect()->to('admin/contents/about-us')->with('success', 'Member has been created.');
    }

    public function teamUpdate(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:meet_our_teams,id'],
            'name' => ['required', 'string', 'max:556'],
            'designation' => ['required', 'string', 'max:556'],
            'institution' => ['required', 'string', 'max:556'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:1024'],
            'sequence' => ['required', 'integer', 'min:0'],
            'type' => ['required', 'in:team,shariah'],
        ]);
        try {
            $team = MeetOurTeam::find($request->id);
            $team->name = $request->name;
            $team->designation = $request->designation;
            $team->institution = $request->institution;
            $team->type = $request->type;
            if (isset($request->image)) {
                $this->removeFile($team->image);

                $image = $this->storeFile('content/about-us', $request->image, 'team');
                $team->image = $image;
            }
            $team->sequence = $request->sequence;
            $team->save();

            return redirect()->to('/admin/contents/about-us')->with('success', 'Team updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function teamDestroy(Request $request)
    {
        try {
            $team = MeetOurTeam::find($request->id);
            $this->removeFile($team->image);
            $team->delete();

            return new JsonResponse(['message' => 'Team Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {

            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
