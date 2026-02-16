<?php

namespace App\Http\Controllers\Admin\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign\CampaignCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CampaignCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('v1.admin.pages.campaign-categories.index');
    }

    /**
     * data for datatable ajax request
     *
     * @return mixed
     */
    public function getCampaignCategoriesDatatableAjax(Request $request)
    {
        // $campaignCategories = CampaignCategory::with('parent_category')
        //     ->orWhereHas('parent_category', function ($query) use ($request) {
        //         if ($request->search['value']) {
        //             $query->orWhere('title', 'like', '%'.$request->search['value'].'%');
        //         }
        //     })
        //     ->orWhere('title', 'like', '%'.$request->search['value'].'%')
        //     ->latest();

        $campaignCategories = CampaignCategory::with('parent_category')
            ->when($request->search['value'] != null, function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->search['value'].'%')
                    ->orWhereHas('parent_category', function ($query) use ($request) {
                        $query->orWhere('title', 'like', '%'.$request->search['value'].'%');
                    });
            })->latest();

        return Datatables::of($campaignCategories)
            ->editColumn('parent_category.title', function ($campaignCategory) {
                return $campaignCategory->parent_category?->title;
            })
            ->addColumn('action', function ($campaignCategory) {
                $markup = '';
                $markup .= '<a href="'.route('admin.campaign-category.edit', [$campaignCategory->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="#" onclick="deleteCampaignCategory('.$campaignCategory->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->rawColumns(['action', 'parent_category.title'])
            ->setFilteredRecords($campaignCategories->count())
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CampaignCategory::where('parent_id', null)->get();

        return view('v1.admin.pages.campaign-categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:campaign_categories,id'],
        ]);
        $campaignCategory = new CampaignCategory();
        $campaignCategory->title = $request->title;
        $campaignCategory->title_bn = $request->title_bn;
        $campaignCategory->title_ar = $request->title_ar;
        $campaignCategory->slug = Str::slug($request->title);
        $campaignCategory->parent_id = $request->parent_id ?? null;
        $campaignCategory->save();

        return redirect()->back()->with('success', 'Campaign Category Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $campaignCategory = CampaignCategory::find($id);
        $categories = CampaignCategory::where('parent_id', null)->where('id', '!=', $id)->get();

        return view('v1.admin.pages.campaign-categories.edit', compact('campaignCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:campaign_categories,id'],
        ]);
        $campaignCategory = CampaignCategory::find($request->id);
        $campaignCategory->title = $request->title;
        $campaignCategory->title_bn = $request->title_bn;
        $campaignCategory->title_ar = $request->title_ar;
        $campaignCategory->slug = Str::slug($request->title);
        $campaignCategory->parent_id = $request->parent_id ?? null;
        $campaignCategory->save();

        return redirect()->back()->with('success', 'Campaign Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $campaignCategory = CampaignCategory::find($request->id);
            $campaignCategory->delete();
            DB::commit();

            return new JsonResponse(['message' => 'Campaign Category Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();

            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
