<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Enums\Transaction\ReceiverType;
use App\Enums\Transaction\TransactionSubType;
use App\Enums\Transaction\TransactionType;
use App\Enums\Transaction\VolunteerPaymentType;
use App\Http\Controllers\Controller;
use App\Models\Bank\Bank;
use App\Models\Bank\BankAccount;
use App\Models\Campaign\Campaign;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceStatus;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionCategory;
use App\Models\Transaction\TransactionMode;
use App\Models\User;
use App\Models\User\UserBank;
use App\Services\InvoiceService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function showIncome()
    {
        $type = 'income';

        return view('v1.admin.pages.invoice.index', compact('type'));
    }

    public function showExpense()
    {
        $type = 'expense';

        return view('v1.admin.pages.invoice.index', compact('type'));
    }

    public function getInvoiceDatatableAjax(Request $request)
    {
        // return $request->search['value'];
        $invoices = Invoice::with([
            'transaction',
            'transaction.transactionCategory',
            'transaction.donorInfo',
            'transaction.volunteerInfo',
            'transaction.campaignInfo',
            'statusInfo',

        ])
            ->whereHas('transaction', function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when($request->search['value'] != null, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->whereHas('statusInfo', function ($query) use ($request) {
                        $query->where('name', 'like', '%'.$request->search['value'].'%');
                    })
                        ->orWhere('sid', 'like', '%'.$request->search['value'].'%')
                        ->orWhereHas('transaction', function ($query) use ($request) {
                            $query->whereHas('campaignInfo', function ($query) use ($request) {
                                $query->where('title', 'like', '%'.$request->search['value'].'%');
                            })
                                ->orWhere('date', 'like', '%'.$request->search['value'].'%')
                                ->orWhereHas('donorInfo', function ($query) use ($request) {
                                    $query->where('name', 'like', '%'.$request->search['value'].'%');
                                })
                                ->orWhereHas('volunteerInfo', function ($query) use ($request) {
                                    $query->where('name', 'like', '%'.$request->search['value'].'%');
                                })
                                ->orWhere('amount', 'like', '%'.$request->search['value'].'%')
                                ->orWhereHas('transactionCategory', function ($query) use ($request) {
                                    $query->where('name', 'like', '%'.$request->search['value'].'%');
                                })
                                ->orWhere('created_at', 'like', '%'.$request->search['value'].'%');
                        });
                });
            })
            ->latest();

        return DataTables::of($invoices)
            ->editColumn('sid', function ($invoice) {
                return $invoice?->sid ?? 'N/A';
            })
            ->editColumn('campaign', function ($invoice) {
                return $invoice?->transaction?->campaignInfo?->title ?? 'N/A';
            })
            ->editColumn('date', function ($invoice) {
                return $invoice?->date ?? 'N/A';
            })
            ->editColumn('giver', function ($invoice) use ($request) {

                $name = '';
                if ($request->type == 'income') {
                    if ($invoice?->transaction?->name != null) {
                        $name = $invoice?->transaction?->name ?? 'N/A';
                    } elseif ($invoice?->transaction?->donorInfo?->name != null) {
                        $name = $invoice?->transaction?->donorInfo?->name ?? 'N/A';
                    } else {
                        $name = 'N/A';
                    }
                } else {
                    $name = $invoice?->transaction?->volunteerInfo->name ?? 'N/A';
                }

                return $name;
            })
            ->editColumn('amount', function ($invoice) {
                return $invoice?->transaction->amount ?? 'N/A';
            })
            ->editColumn('transaction_category', function ($invoice) {
                return $invoice?->transaction?->transactionCategory->name ?? 'N/A';
            })
            ->editColumn('status', function ($invoice) {
                return $invoice?->statusInfo->name ?? 'N/A';
            })
            ->editColumn('created_at', function ($invoice) {
                return $invoice->created_at ?? 'N/A';
            })
            ->addColumn('action', function ($invoice) {
                $markup = '';
                $markup .= '<a href="'.route('admin.invoice.show', [$invoice->id]).'" class="btn btn-primary m-1">Show</a>';
                $markup .= '<a href="'.route('admin.invoice.edit', [$invoice->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="#" onclick="deleteInvoice('.$invoice->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->rawColumns(['sid', 'campaign', 'date', 'giver', 'amount', 'transaction_category', 'action', 'status', 'created_at'])
            ->setFilteredRecords($invoices->count())
            ->make(true);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type)
    {
        $campaigns = Campaign::with(['seeker_application.volunteers'])->get();
        $donors = User::where(function ($q) {
            $q->where('type', 'donor')
                ->orWhere('type', 'corporate-donor');
        })
            ->where('status', 'approved')
            ->latest()
            ->get();
        $volunteers = User::where('type', 'volunteer')->latest()->get();
        $invoices = Invoice::with(['transaction', 'transaction.transactionCategory'])->latest()->get();
        $banks = Bank::all();
        $bankAccounts = BankAccount::all();
        $transactionCategories = TransactionCategory::whereIn('type', [$type, 'both'])->get();
        $transactionModes = TransactionMode::whereIn('type', [$type, 'both'])->get();
        $statuses = InvoiceStatus::whereIn('type', [$type, 'both'])->get();
        $volunteerPaymentTypes = VolunteerPaymentType::values();

        return view('v1.admin.pages.invoice.create', compact('invoices', 'type', 'campaigns', 'donors', 'banks', 'bankAccounts', 'transactionCategories', 'transactionModes', 'statuses', 'volunteers', 'volunteerPaymentTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $selectBankAccount = BankAccount::findOrFail($request->bank_account_id);
        $validated = $request->validate([
            'type' => ['required', Rule::in(TransactionType::values())],
            'receiver_type' => ['required_if:type,income', 'nullable', Rule::in(ReceiverType::values())],
            'campaign_id' => ['required_if:type,income', 'nullable', 'exists:campaigns,id'],
            'status' => ['nullable', 'string', 'exists:invoice_statuses,id'],
            'created_by' => ['nullable', 'exists:users,id'],
            'date' => ['required', 'date'],
            'user_bank_id' => [
                'nullable',
                'exists:user_banks,id',
                Rule::requiredIf($request->sub_type == TransactionSubType::General->value || $request->sub_type == TransactionSubType::Campaign->value),
            ],
            'bank_id' => ['required', 'exists:banks,id'],
            'bank_account_id' => ['required', 'exists:bank_accounts,id'],
            'transaction_category_id' => ['nullable', 'exists:transaction_categories,id'],
            'transaction_mode_id' => ['nullable', 'exists:transaction_modes,id'],
            'amount' => ['required',
                'numeric',
                'min:0',
                Rule::when($request->input('type') === 'expense', [
                    'max:'.$selectBankAccount->current_balance,
                ]),
                'regex:/^\d+(\.\d{1,2})?$/'],
            'remarks' => ['nullable', 'string'],
            'sub_type' => ['required_if:type,expense', 'nullable', Rule::in(TransactionSubType::values())],
            'volunteer_id' => ['required_if:sub_type,campaign', 'nullable', 'exists:users,id'],
            'donor_id' => ['required_if:receiver_type,donor', 'nullable', 'exists:users,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'mobile' => ['required_if:receiver_type,anonymous', 'nullable', 'string'],
            'volunteer_payment_type' => ['required_if:sub_type,campaign', 'nullable', Rule::in(VolunteerPaymentType::values())],
        ]);

        try {
            DB::beginTransaction();

            $paymentDateTime = Carbon::parse($validated['date'])->toDateTimeString();

            $invoice = Invoice::create([
                'campaign_id' => $validated['campaign_id'] ?? null,
                'status' => $validated['status'] ?? null,
                'date' => $paymentDateTime ?? null,
                'created_by' => Auth::id(),
            ]);

            $invoice->sid = ($validated['type'] == 'income' ? 'IN-' : 'EX-').(100_000 + $invoice->id);
            $invoice->save();

            $transaction = Transaction::create([
                'receiver_type' => $validated['receiver_type'] ?? null,
                'date' => $paymentDateTime,
                'amount' => $validated['amount'],
                'remarks' => $validated['remarks'] ?? null,
                'status' => $validated['status'] ?? null,
                'type' => $validated['type'],
                'sub_type' => $validated['type'] == 'income' ? 'manual' : $validated['sub_type'],
                'campaign_id' => $validated['campaign_id'] ?? null,
                'transaction_category_id' => $validated['transaction_category_id'] ?? null,
                'transaction_mode_id' => $validated['transaction_mode_id'] ?? null,
                'user_bank_id' => $validated['user_bank_id'] ?? null,
                'bank_id' => $validated['bank_id'] ?? null,
                'bank_account_id' => $validated['bank_account_id'] ?? null,
                'invoice_id' => $invoice->id ?? null,
                'donor_id' => $validated['donor_id'] ?? null,
                'name' => $validated['name'] ?? null,
                'mobile' => $validated['mobile'] ?? null,
                'volunteer_id' => $validated['volunteer_id'] ?? null,
                'created_by' => auth()->id(),
                'volunteer_payment_type' => $validated['volunteer_payment_type'] ?? null,
            ]);

            $bankAccount = BankAccount::findOrFail($validated['bank_account_id']);
            if ($validated['type'] == 'income') {
                $bankAccount->current_balance = $bankAccount->current_balance + $validated['amount'];
            } else {
                $bankAccount->current_balance = $bankAccount->current_balance - $validated['amount'];
            }
            $bankAccount->save();

            DB::commit();

            return redirect()->to('/admin/invoice/'.$validated['type'])->with('success', ucfirst($validated['type']).' transaction created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::with([
            'transaction',
            'statusInfo',
            'transaction.transactionCategory',
            'transaction.donorInfo',
            'transaction.volunteerInfo',
            'transaction.campaignInfo',
            'transaction.userBank',
            'transaction.bankInfo',
            'transaction.bankAccountInfo',
        ])
            ->findOrFail($id);

        $type = $invoice->transaction->type;

        return view('v1.admin.pages.invoice.show', compact('invoice', 'type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = Invoice::with([
            'transaction',
            'statusInfo',
            'transaction.transactionCategory',
            'transaction.donorInfo',
            'transaction.volunteerInfo',
        ])
            ->findOrFail($id);
        $type = $invoice->transaction->type;

        $campaigns = Campaign::all();
        $donors = User::where('type', 'donor')->latest()->get();
        $volunteers = User::where('type', 'volunteer')->latest()->get();
        $banks = Bank::all();
        $bankAccounts = BankAccount::all();
        $transactionCategories = TransactionCategory::whereIn('type', [$type, 'both'])->get();
        $transactionModes = TransactionMode::whereIn('type', [$type, 'both'])->get();
        $statuses = InvoiceStatus::whereIn('type', [$type, 'both'])->get();
        $volunteerPaymentTypes = VolunteerPaymentType::values();

        return view('v1.admin.pages.invoice.edit', compact('invoice', 'type', 'campaigns', 'donors', 'banks', 'bankAccounts', 'transactionCategories', 'transactionModes', 'statuses', 'volunteers', 'volunteerPaymentTypes'));
        // return view('v1.admin.pages.invoice.edit', compact('invoice', 'type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $selectBankAccount = BankAccount::findOrFail($request->bank_account_id);
        $validated = $request->validate([
            'type' => ['required', Rule::in(TransactionType::values())],
            'receiver_type' => ['nullable', Rule::in(ReceiverType::values())],
            'campaign_id' => ['nullable', 'exists:campaigns,id'],
            'id' => ['required', 'exists:invoices,id'],
            'status' => ['nullable', 'string', 'exists:invoice_statuses,id'],
            'created_by' => ['nullable', 'exists:users,id'],
            'date' => ['required', 'date'],
            'bank_id' => ['required', 'exists:banks,id'],
            'bank_account_id' => ['required', 'exists:bank_accounts,id'],
            'transaction_category_id' => ['nullable', 'exists:transaction_categories,id'],
            'transaction_mode_id' => ['nullable', 'exists:transaction_modes,id'],
            'amount' => ['required',
                'numeric',
                'min:0',
                Rule::when($request->input('type') === 'expense', [
                    'max:'.$selectBankAccount->current_balance,
                ]),
                'regex:/^\d+(\.\d{1,2})?$/'],
            'remarks' => ['nullable', 'string'],
            'sub_type' => ['nullable', Rule::in(TransactionSubType::values())],
            'volunteer_id' => ['required_if:sub_type,campaign', 'nullable', 'exists:users,id'],
            'donor_id' => ['required_if:receiver_type,donor', 'nullable', 'exists:users,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'mobile' => ['required_if:receiver_type,anonymous', 'nullable', 'string', 'unique:users,mobile'],
            'volunteer_payment_type' => ['required_if:sub_type, campaign', 'nullable', Rule::in(VolunteerPaymentType::values())],
        ]);
        try {
            DB::beginTransaction();

            $paymentDateTime = Carbon::parse($validated['date'])->toDateTimeString();

            $invoice = Invoice::findOrFail($validated['id']);

            $invoice->update([
                'campaign_id' => $validated['campaign_id'] ?? null,
                'status' => $validated['status'] ?? null,
                'date' => $paymentDateTime ?? null,
            ]);
            // $invoice->sid = 'IN-'.(100_000 + $invoice->id);
            // $invoice->save();

            $transaction = $invoice->transaction;

            $bankAccount = BankAccount::findOrFail($validated['bank_account_id']);
            if ($validated['type'] == 'income') {
                $bankAccount->current_balance = $bankAccount->current_balance + $validated['amount'] - $transaction->amount;
            } else {
                $bankAccount->current_balance = $bankAccount->current_balance - $validated['amount'] + $transaction->amount;
            }
            $bankAccount->save();

            $transaction->update([
                'receiver_type' => $validated['receiver_type'] ?? null,
                'date' => $paymentDateTime,
                'amount' => $validated['amount'],
                'remarks' => $validated['remarks'] ?? null,
                'status' => $validated['status'] ?? null,
                'type' => $validated['type'],
                'sub_type' => $validated['type'] == 'income' ? 'manual' : $validated['sub_type'],
                'campaign_id' => $validated['campaign_id'] ?? null,
                'transaction_category_id' => $validated['transaction_category_id'] ?? null,
                'transaction_mode_id' => $validated['transaction_mode_id'] ?? null,
                'bank_id' => $validated['bank_id'] ?? null,
                'bank_account_id' => $validated['bank_account_id'] ?? null,
                'invoice_id' => $invoice->id ?? null,
                'donor_id' => $validated['donor_id'] ?? null,
                'name' => $validated['name'] ?? null,
                'mobile' => $validated['mobile'] ?? null,
                'volunteer_id' => $validated['volunteer_id'] ?? null,
                'volunteer_payment_type' => $validated['volunteer_payment_type'] ?? null,
            ]);

            DB::commit();

            return redirect()->to('/admin/invoice/'.$validated['type'])->with('success', ucfirst($validated['type']).' transaction updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $invoice = Invoice::findOrFail($request->id);
            $invoice->delete();

            return new JsonResponse(['message' => ucfirst($request->type).' Transaction Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserBank($userId)
    {
        $userBank = UserBank::where('user_id', $userId)->get();

        return response()->json(['data' => $userBank]);
    }
}
