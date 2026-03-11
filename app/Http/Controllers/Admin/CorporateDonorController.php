<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Campaign\Campaign;
use App\Models\CorporateAllocation;
use App\Models\CorporateWallet;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Notifications\CorporateAllocationNotification;
use App\Models\Transaction\Transaction;
use App\Models\Invoice\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CorporateDonorController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('status', 'ongoing')->get()->filter(function ($campaign) {
            $totalRaised = \App\Models\Transaction\Transaction::where('campaign_id', $campaign->id)
                            ->where('type', 'income')
                            ->sum('amount');
            return $totalRaised < $campaign->amount;
        })->values();

        $pendingCount = User::where('type', 'corporate-donor')->where('status', 'pending')->count();
        return view('v1.admin.pages.corporate_donors.index', compact('campaigns', 'pendingCount'));
    }

    /**
     * Get data for DataTables.
     */
    public function getDatatableAjax(Request $request)
    {
        $query = User::where('type', 'corporate-donor')
            ->orderBy('id', 'desc')
            ->with('corporateWallet');

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'approved');
        }

        return Datatables::of($query)
            ->addColumn('wallet', function ($row) {
                $balance = $row->corporateWallet ? $row->corporateWallet->balance : 0;
                return 'Tk ' . number_format($balance, 2);
            })
            ->addColumn('status_badge', function ($row) {
                $color = match($row->status) {
                    'approved' => 'success',
                    'pending'  => 'warning',
                    'rejected' => 'danger',
                    default    => 'secondary',
                };
                return '<span class="badge badge-' . $color . '">' . ucfirst($row->status) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $btns = '';
                if ($row->status === 'pending') {
                    $btns .= '<button class="btn btn-xs btn-success btn-approve-donor mr-1" data-id="' . $row->id . '"><i class="fas fa-check"></i> Approve</button>';
                    $btns .= '<button class="btn btn-xs btn-danger btn-reject-donor" data-id="' . $row->id . '"><i class="fas fa-times"></i> Reject</button>';
                } elseif ($row->status === 'approved') {
                    $btns .= '<button class="btn btn-sm btn-info btn-allocate mr-1" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="fas fa-coins"></i> Allocate</button>';
                    $btns .= '<button class="btn btn-sm btn-secondary btn-allocations" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="fas fa-history"></i> History</button>';
                }
                return $btns;
            })
            ->rawColumns(['action', 'status_badge'])
            ->make(true);
    }

    public function approveDonor(int $id)
    {
        User::where('id', $id)->where('type', 'corporate-donor')->update(['status' => 'approved']);
        return response()->json(['success' => true, 'message' => 'Corporate donor approved.']);
    }

    public function rejectDonor(int $id)
    {
        User::where('id', $id)->where('type', 'corporate-donor')->update(['status' => 'rejected']);
        return response()->json(['success' => true, 'message' => 'Corporate donor rejected.']);
    }

    /**
     * Allocate funds from a corporate donor to a campaign.
     */
    public function allocate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $donor = User::where('id', $request->user_id)->where('type', 'corporate-donor')->firstOrFail();
        $wallet = CorporateWallet::firstOrCreate(
            ['user_id' => $donor->id],
            ['balance' => 0, 'total_deposited' => 0]
        );

        if ($wallet->balance < $request->amount) {
            return response()->json(['success' => false, 'message' => 'Insufficient wallet balance.']);
        }

        DB::beginTransaction();
        try {
            // 1. Deduct from wallet
            $wallet->balance -= $request->amount;
            $wallet->save();

            // 2. Record Allocation
            CorporateAllocation::create([
                'user_id' => $donor->id,
                'campaign_id' => $request->campaign_id,
                'amount' => $request->amount,
                'allocated_at' => now(),
            ]);

            // 3. Create Invoice & Transaction to credit the Campaign
            $paymentDateTime = Carbon::now();

            $invoice = Invoice::create([
                'campaign_id' => $request->campaign_id,
                'status' => 1,
                'date' => $paymentDateTime,
                'created_by' => Auth::id(),
            ]);

            $invoice->sid = 'IN-'.(100_000 + $invoice->id);
            $invoice->save();

            Transaction::create([
                'receiver_type' => 'donor',
                'date' => $paymentDateTime,
                'amount' => $request->amount,
                'remarks' => 'Corporate Allocation',
                'status' => 1,
                'type' => 'income',
                'sub_type' => 'digital',
                'campaign_id' => $request->campaign_id,
                'transaction_category_id' => null,
                'transaction_mode_id' => null,
                'bank_id' => 1, 
                'bank_account_id' => 1,
                'invoice_id' => $invoice->id,
                'donor_id' => $donor->id,
                'name' => $donor->name,
                'mobile' => $donor->mobile,
                'volunteer_id' => null,
                'created_by' => Auth::id(),
            ]);

            // Campaign goal is satisfied implicitly since we record the Allocation. 
            // The Campaign's total raised is evaluated virtually via transactions.

            DB::commit();

            // 4. Send Database Notification to the Corporate Donor
            $donor->notify(new CorporateAllocationNotification($request->amount, $campaign->title, $wallet->balance));

            return response()->json(['success' => true, 'message' => 'Funds allocated securely. Wallet updated!']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Get a list of past allocations for a specific corporate donor.
     */
    public function allocations($id)
    {
        $allocations = CorporateAllocation::with('campaign')
            ->where('user_id', $id)
            ->latest('id')
            ->get();
            
        return response()->json(['success' => true, 'allocations' => $allocations]);
    }

    /**
     * Refund a corporate allocation back to the donor's wallet.
     */
    public function refundAllocation(Request $request, $id)
    {
        $allocation = CorporateAllocation::findOrFail($id);
        
        $donor = User::where('id', $allocation->user_id)->where('type', 'corporate-donor')->firstOrFail();
        $campaign = Campaign::findOrFail($allocation->campaign_id);
        $wallet = CorporateWallet::where('user_id', $allocation->user_id)->firstOrFail();

        DB::beginTransaction();
        try {
            // 1. Delete associated transactions and invoice that credited the campaign
            $transaction = Transaction::where('donor_id', $allocation->user_id)
                ->where('campaign_id', $allocation->campaign_id)
                ->where('amount', $allocation->amount)
                ->latest('id')
                ->first();
                
            if($transaction) {
                if($transaction->invoice_id) {
                    Invoice::where('id', $transaction->invoice_id)->delete();
                }
                $transaction->delete();
            }

            // 2. Add funds back to the corporate wallet
            $wallet->balance += $allocation->amount;
            $wallet->save();

            // 3. Delete the allocation record
            $refundAmount = $allocation->amount;
            $allocation->delete();

            DB::commit();

            // 4. Send Database Notification to the Corporate Donor
            $donor->notify(new \App\Notifications\RefundAllocationNotification($refundAmount, $campaign->title, $wallet->balance));

            return response()->json(['success' => true, 'message' => 'Allocation refunded successfully. Wallet balance updated.']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Refund Failed: ' . $e->getMessage()]);
        }
    }
}
