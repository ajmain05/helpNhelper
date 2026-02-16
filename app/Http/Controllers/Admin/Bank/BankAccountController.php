<?php

namespace App\Http\Controllers\Admin\Bank;

use App\Http\Controllers\Controller;
use App\Models\Bank\Bank;
use App\Models\Bank\BankAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('v1.admin.pages.bank-account.index');
    }

    public function getbankAccountDatatableAjax(Request $request)
    {
        $bankAccounts = BankAccount::with(['bank'])
            ->when($request->search['value'] != null, function ($query) use ($request) {
                $query->whereHas('bank', function ($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->search['value'].'%');
                })
                    ->orWhere('branch_name', 'like', '%'.$request->search['value'].'%')
                    ->orWhere('account_number', 'like', '%'.$request->search['value'].'%')
                    ->orWhere('opening_balance', 'like', '%'.$request->search['value'].'%')
                    ->orWhere('current_balance', 'like', '%'.$request->search['value'].'%')
                    ->orWhere('created_at', 'like', '%'.$request->search['value'].'%');
            })
            ->latest();

        $rowIndex = 0;

        // return $bankAccounts;
        return DataTables::of($bankAccounts)
            ->editColumn('bank.name', function ($bankAccounts) {
                return $bankAccounts?->bank?->name;
            })
            ->editColumn('branch_name', function ($bankAccounts) {
                return $bankAccounts?->branch_name;
            })
            ->editColumn('account_number', function ($bankAccounts) {
                return $bankAccounts?->account_number;
            })
            ->editColumn('opening_balance', function ($bankAccounts) {
                return $bankAccounts?->opening_balance;
            })
            ->editColumn('current_balance', function ($bankAccounts) {
                return $bankAccounts?->current_balance;
            })
            ->editColumn('created_at', function ($bankAccounts) {
                return $bankAccounts?->created_at ?? 'N/A';
            })
            ->addColumn('action', function ($bankAccounts) use (&$rowIndex) {
                $markup = '';
                $rowIndex++;
                // $markup .= '<a href="'.route('admin.bank.show', [$campaign->id]).'" class="btn btn-primary m-1">Show</a>';
                $markup .= '<a href="'.route('admin.bank-account.edit', [$bankAccounts->id]).'" class="btn btn-secondary m-1">Edit</a>';
                if ($rowIndex > 1) {
                    $markup .= '<a href="#" onclick="deleteBankAccount('.$bankAccounts->id.')" class="btn btn-danger m-1">Delete</a>';
                }

                return $markup;
            })
            ->rawColumns(['action', 'bank.name', 'branch_name', 'account_number', 'opening_balance', 'current_balance', 'created_at'])
            ->setFilteredRecords($bankAccounts->count())
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $banks = Bank::all();

        return view('v1.admin.pages.bank-account.create', compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'branch_name' => ['required', 'string', 'min: 2'],
            'account_number' => ['required', 'string', 'min: 2'],
            'opening_balance' => ['required', 'numeric', 'max:1000000000'],
            'bank' => ['required', 'integer', 'exists:banks,id'],
            'remarks' => ['nullable', 'string'],
        ]);

        try {
            $bankAccount = BankAccount::create([
                'branch_name' => $request->branch_name ?? null,
                'account_number' => $request->account_number ?? null,
                'opening_balance' => $request->opening_balance ?? null,
                'current_balance' => $request->opening_balance ?? null,
                'bank_id' => $request->bank ?? null,
                'remarks' => $request->remarks ?? null,
            ]);

            return redirect()->to('/admin/bank-account')->with('success', 'Bank account created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $banks = Bank::all();
        $bankAccount = BankAccount::find($id);

        return view('v1.admin.pages.bank-account.edit', compact('bankAccount', 'banks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'branch_name' => ['required', 'string', 'min: 2'],
            'account_number' => ['required', 'string', 'min: 2'],
            'opening_balance' => ['required', 'numeric', 'max:1000000000'],
            'bank' => ['required', 'integer', 'exists:banks,id'],
            'remarks' => ['nullable', 'string'],
        ]);

        try {
            $bankAccount = BankAccount::findOrFail($request->id);

            $bankAccount->branch_name = $request->branch_name ?? null;
            $bankAccount->account_number = $request->account_number ?? null;
            $bankAccount->opening_balance = $request->opening_balance ?? null;
            $bankAccount->current_balance = $request->opening_balance ?? null;
            $bankAccount->bank_id = $request->bank ?? null;
            $bankAccount->remarks = $request->remarks ?? null;

            $bankAccount->save();

            return redirect()->to('/admin/bank-account')->with('success', 'Bank account created successfully.');
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
            $bank = BankAccount::findOrFail($request->id);
            $bank->delete();

            return new JsonResponse(['message' => 'Bank account Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
