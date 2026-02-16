<?php

namespace App\Http\Controllers\Admin\Rating;

use App\Http\Controllers\Controller;
use App\Models\Rating\RatingType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RatingController extends Controller
{
    public function index()
    {
        return view('v1.admin.pages.rating-type.index');
    }

    public function getSuccessDatatableAjax(Request $request)
    {
        $ratingTypes = RatingType::when($request->search['value'] != null, function ($query) use ($request) {
            $query->Where('title', 'like', '%'.$request->search['value'].'%');
        })->latest();

        return Datatables::of($ratingTypes)->addColumn('action', function ($ratingTypes) {
            $markup = '';
            $markup .= '<a href="'.route('admin.rating-types.edit', [$ratingTypes->id]).'" class="btn btn-secondary m-1">Edit</a>';
            $markup .= '<a href="#" onclick="deleteSuccess('.$ratingTypes->id.')" class="btn btn-danger m-1"> Delete</a>';

            return $markup;
        })
            ->rawColumns(['action'])
            ->setFilteredRecords($ratingTypes->count())
            ->make(true);
    }

    public function create()
    {
        return view('v1.admin.pages.rating-type.create');
    }

    public function edit(string $id)
    {
        $ratingType = RatingType::find($id);

        return view('v1.admin.pages.rating-type.edit', compact('ratingType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'highest_score' => ['required', 'numeric', 'max:100'],
            'remarks' => ['nullable', 'string'],
        ]);
        DB::beginTransaction();
        try {
            $ratingType = RatingType::find($id);
            $ratingType->title = $request->title;
            $ratingType->highest_score = $request->highest_score;
            $ratingType->remarks = $request->remarks;
            $ratingType->save();

            DB::commit();

            return redirect()->to('/admin/rating-types')->with('success', 'Rating type updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'highest_score' => ['required', 'numeric', 'max:100'],
            'remarks' => ['nullable', 'string'],
        ]);

        try {
            $ratingType = RatingType::create([
                'title' => $request->title,
                'highest_score' => $request->highest_score,
                'remarks' => $request->remarks ?? null,
            ]);

            return redirect()->to('/admin/rating-types')->with('success', 'Rating type created successfully.');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $ratingType = RatingType::find($request->id);
            $ratingType->delete();

            return new JsonResponse(['message' => 'Rating type Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
