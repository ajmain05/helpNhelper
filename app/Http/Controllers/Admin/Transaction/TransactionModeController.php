<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Enums\Transaction\TransactionType;
use App\Http\Controllers\Controller;
use App\Models\Transaction\TransactionMode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class TransactionModeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('v1.admin.pages.transaction-mode.index');
    }

    public function getTransactionModeDatatableAjax(Request $request)
    {
        $transactionMode = TransactionMode::all();

        return DataTables::of($transactionMode)
            ->editColumn('name', function ($transactionMode) {
                return $transactionMode?->name;
            })
            ->editColumn('type', function ($transactionMode) {
                return $transactionMode?->type;
            })
            ->addColumn('action', function ($transactionMode) {
                $markup = '';
                // $markup .= '<a href="'.route('admin.bank.show', [$campaign->id]).'" class="btn btn-primary m-1">Show</a>';
                $markup .= '<a href="'.route('admin.transaction-mode.edit', [$transactionMode->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="#" onclick="deleteTransactionMode('.$transactionMode->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->rawColumns(['action', 'name', 'type'])
            ->setFilteredRecords($transactionMode->count())
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = TransactionType::values();

        return view('v1.admin.pages.transaction-mode.create', compact('types'));
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

            $transactionMode = TransactionMode::create([
                'created_by' => Auth::id(),
                'name' => $request->name,
                'type' => $request->type,
            ]);

            return redirect()->to('/admin/transaction-mode')->with('success', 'Transaction Mode created successfully.');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionMode $transactionMode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transactionMode = TransactionMode::find($id);
        $types = TransactionType::values();

        return view('v1.admin.pages.transaction-mode.edit', compact('transactionMode', 'types'));
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
            $transactionMode = TransactionMode::findOrFail($request->id);
            $transactionMode->name = $request->name;
            $transactionMode->type = $request->type;
            $transactionMode->save();

            return redirect()->to('/admin/transaction-mode')->with('success', 'Transaction Mode updated successfully.');
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
            $transactionMode = TransactionMode::findOrFail($request->id);
            $transactionMode->delete();

            return new JsonResponse(['message' => 'Transaction Mode Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
