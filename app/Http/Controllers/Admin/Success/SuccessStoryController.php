<?php

namespace App\Http\Controllers\Admin\Success;

use App\Http\Controllers\Controller;
use App\Models\Campaign\Campaign;
use App\Models\SuccessStory;
use App\Traits\HasFiles;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SuccessStoryController extends Controller
{
    use HasFiles;

    public function index()
    {
        return view('v1.admin.pages.success-story.index');
    }

    public function getSuccessDatatableAjax(Request $request)
    {
        $success = SuccessStory::with(['campaign'])
            ->when($request->search['value'] != null, function ($query) use ($request) {
                $query->whereHas('campaign', function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->search['value'].'%');
                })
                    ->orWhere('title', 'like', '%'.$request->search['value'].'%')
                    ->orWhere('created_at', 'like', '%'.$request->search['value'].'%');
            })->latest();

        return Datatables::of($success)
            ->editColumn('campaign.title', function ($success) {
                return $success?->campaign?->title;
            })
            ->editColumn('created_at', function ($success) {
                return $success->created_at ?? 'N/A';
            })
            ->addColumn('action', function ($campaign) {
                $markup = '';
                // $markup .= '<a href="'.route('admin.success.show', [$campaign->id]).'" class="btn btn-primary m-1">Show</a>';
                $markup .= '<a href="'.route('admin.success.edit', [$campaign->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="#" onclick="deleteSuccess('.$campaign->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->rawColumns(['action', 'campaign.title', 'created_at'])
            ->setFilteredRecords($success->count())
            ->make(true);
    }

    public function create()
    {
        $successStory = SuccessStory::all();
        $campaigns = Campaign::all();

        return view('v1.admin.pages.success-story.create', compact('successStory', 'campaigns'));
    }

    public function edit(string $id)
    {
        $successStory = SuccessStory::find($id);
        $campaigns = Campaign::all();

        return view('v1.admin.pages.success-story.edit', compact('successStory', 'campaigns'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // return $request;
        $request->validate([
            'id' => ['required'],
            'title' => ['required', 'string'],
            'short_description' => ['required', 'string'],
            'long_description' => ['required', 'string'],
            'photo' => ['nullable', 'file', 'max:2048'],
            'previous_condition' => ['nullable', 'file', 'max:2048'],
            'present_condition' => ['nullable', 'file', 'max:2048'],
        ]);
        DB::beginTransaction();
        try {
            $successStory = SuccessStory::find($request->id);
            $successStory->title = $request->title;
            $successStory->title_bn = $request->title_bn;
            $successStory->title_ar = $request->title_ar;
            $successStory->short_description = $request->short_description;
            $successStory->short_description_bn = $request->short_description_bn;
            $successStory->short_description_ar = $request->short_description_ar;
            $successStory->long_description = $request->long_description;
            $successStory->long_description_bn = $request->long_description_bn;
            $successStory->long_description_ar = $request->long_description_ar;
            if ($request->file('photo')) {
                $photoPath = $this->storeFile('successStories', $request->file('photo'), 'successStory');
                $successStory->photo = $photoPath;
            }
            if ($request->file('previous_condition')) {
                $previousCondition = $this->storeFile('successStories', $request->file('previous_condition'), 'successStory');
                $successStory->previous_condition = $previousCondition;
            }
            if ($request->file('present_condition')) {
                $presentCondition = $this->storeFile('successStories', $request->file('present_condition'), 'successStory');
                $successStory->present_condition = $presentCondition;
            }
            $successStory->save();

            DB::commit();

            return redirect()->to('/admin/success')->with('success', 'Success Story updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'short_description' => 'required',
            'long_description' => 'nullable',
            'photo' => 'required',
            'photo.*' => 'file', 'mimes:jpeg,png,jpg',
            'campaign_id' => 'required',
            'previous_condition' => 'required',
            'present_condition' => 'required',
        ]);

        try {
            if ($request->file('photo')) {
                $photoPath = $this->storeFile('success-story', $request->file('photo'), 'success');
            }
            if ($request->file('previous_condition')) {
                $previousCondition = $this->storeFile('success-story', $request->file('previous_condition'), 'success');
            }
            if ($request->file('present_condition')) {
                $presentCondition = $this->storeFile('success-story', $request->file('present_condition'), 'success');
            }
            $success = SuccessStory::create([
                'campaign_id' => $request->campaign_id,
                'title' => $request->title,
                'title_bn' => $request->title_bn,
                'title_ar' => $request->title_ar,
                'short_description' => $request->short_description,
                'short_description_bn' => $request->short_description_bn,
                'short_description_ar' => $request->short_description_ar,
                'long_description' => $request->long_description,
                'long_description_bn' => $request->long_description_bn,
                'long_description_ar' => $request->long_description_ar,
                'photo' => $photoPath,
                'previous_condition' => $previousCondition,
                'present_condition' => $presentCondition,
            ]);

            return redirect()->to('/admin/success')->with('success', 'Success Story created successfully.');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $success = SuccessStory::find($request->id);
            $success->delete();

            return new JsonResponse(['message' => 'Success Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
