<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Enums\Transaction\TransactionType;
use App\Http\Controllers\Controller;
use App\Models\Transaction\TransactionCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('v1.admin.pages.transaction-category.index');
    }

    public function getTransactionCategoryDatatableAjax(Request $request)
    {
        $transactionCategory = TransactionCategory::all();

        return DataTables::of($transactionCategory)
            ->editColumn('name', function ($transactionCategory) {
                return $transactionCategory?->name;
            })
            ->editColumn('type', function ($transactionCategory) {
                return $transactionCategory?->type;
            })
            ->addColumn('action', function ($transactionCategory) {
                $markup = '';
                // $markup .= '<a href="'.route('admin.bank.show', [$campaign->id]).'" class="btn btn-primary m-1">Show</a>';
                $markup .= '<a href="'.route('admin.transaction-category.edit', [$transactionCategory->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="#" onclick="deleteTransactionCategory('.$transactionCategory->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->rawColumns(['action', 'name', 'type'])
            ->setFilteredRecords($transactionCategory->count())
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = TransactionType::values();

        return view('v1.admin.pages.transaction-category.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'type' => ['required', Rule::in(TransactionType::values())],
        ]);
        try {

            $transactionCategory = TransactionCategory::create([
                'created_by' => Auth::id(),
                'name' => $request->name,
                'type' => $request->type,
            ]);

            return redirect()->to('/admin/transaction-category')->with('success', 'Transaction Category created successfully.');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionCategory $transactionCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transactionCategory = TransactionCategory::find($id);
        $types = TransactionType::values();

        return view('v1.admin.pages.transaction-category.edit', compact('transactionCategory', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'type' => ['required', Rule::in(TransactionType::values())],
        ]);
        try {
            $transactionCategory = TransactionCategory::findOrFail($request->id);
            $transactionCategory->name = $request->name;
            $transactionCategory->type = $request->type;
            $transactionCategory->save();

            return redirect()->to('/admin/transaction-category')->with('success', 'Transaction Category updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $transactionCategory = TransactionCategory::findOrFail($request->id);
            $transactionCategory->delete();

            return new JsonResponse(['message' => 'Transaction Category Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
