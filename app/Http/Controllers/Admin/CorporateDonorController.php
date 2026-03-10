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
use App\Notifications\AllocationNotification;

class CorporateDonorController extends Controller
{
    public function index()
    {
        $campaigns    = Campaign::where('status', 'approved')->get();
        $pendingCount = User::where('type', 'corporate-donor')->where('status', 'pending')->count();
        return view('v1.admin.pages.corporate_donors.index', compact('campaigns', 'pendingCount'));
    }

    /**
     * Get data for DataTables.
     */
    public function getDatatableAjax()
    {
        $donors = User::where('type', 'corporate-donor')
            ->orderBy('id', 'desc')
            ->with('corporateWallet')
            ->get();

        return Datatables::of($donors)
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
                    $btns .= '<button class="btn btn-sm btn-info btn-allocate" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="fas fa-coins"></i> Allocate Funds</button>';
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

            // 3. Update Campaign Goal/Raised (assuming structure is total_raised/amount_raised)
            $campaign = Campaign::findOrFail($request->campaign_id);
            if(isset($campaign->total_raised)) {
                 $campaign->total_raised += $request->amount;
            } elseif(isset($campaign->amount_raised)) {
                 $campaign->amount_raised += $request->amount;
            } else {
                 $campaign->totalRaised += $request->amount;
            }
            $campaign->save();

            DB::commit();

            // 4. Send Database Notification to the Corporate Donor
            $donor->notify(new AllocationNotification($request->amount, $campaign->title, $wallet->balance));

            return response()->json(['success' => true, 'message' => 'Funds allocated securely. Wallet updated!']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
