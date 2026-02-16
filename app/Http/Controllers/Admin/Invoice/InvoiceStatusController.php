<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Enums\Transaction\TransactionType;
use App\Http\Controllers\Controller;
use App\Models\Invoice\InvoiceStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class InvoiceStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('v1.admin.pages.invoice-status.index');
    }

    public function getTInvoiceStatusDatatableAjax(Request $request)
    {
        $invoiceStatuses = InvoiceStatus::all();

        return DataTables::of($invoiceStatuses)
            ->editColumn('name', function ($invoiceStatuses) {
                return $invoiceStatuses?->name;
            })
            ->editColumn('type', function ($transactionMode) {
                return $transactionMode?->type;
            })
            ->addColumn('action', function ($invoiceStatuses) {
                $markup = '';
                // $markup .= '<a href="'.route('admin.bank.show', [$campaign->id]).'" class="btn btn-primary m-1">Show</a>';
                $markup .= '<a href="'.route('admin.invoice-status.edit', [$invoiceStatuses->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="#" onclick="deleteInvoiceStatus('.$invoiceStatuses->id.')" class="btn btn-danger m-1">Delete</a>';

                return $markup;
            })
            ->rawColumns(['action', 'name', 'type'])
            ->setFilteredRecords($invoiceStatuses->count())
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = TransactionType::values();

        return view('v1.admin.pages.invoice-status.create', compact('types'));
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

            $invoiceStatus = InvoiceStatus::create([
                'created_by' => Auth::id(),
                'name' => $request->name,
                'type' => $request->type,
            ]);

            return redirect()->to('/admin/invoice-status')->with('success', 'Invoice Status created successfully.');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceStatus $invoiceStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoiceStatus = InvoiceStatus::find($id);
        $types = TransactionType::values();

        return view('v1.admin.pages.invoice-status.edit', compact('invoiceStatus', 'types'));
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
            $invoiceStatus = InvoiceStatus::findOrFail($request->id);
            $invoiceStatus->name = $request->name;
            $invoiceStatus->type = $request->type;
            $invoiceStatus->save();

            return redirect()->to('/admin/invoice-status')->with('success', 'Invoice Status updated successfully.');
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
            $invoiceStatus = InvoiceStatus::findOrFail($request->id);
            $invoiceStatus->delete();

            return new JsonResponse(['message' => 'Invoice Status Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
