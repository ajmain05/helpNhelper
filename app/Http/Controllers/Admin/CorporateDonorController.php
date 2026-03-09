<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Campaign;
use App\Models\CorporateAllocation;
use App\Models\CorporateWallet;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Notifications\AllocationNotification;

class CorporateDonorController extends Controller
{
    /**
     * Display a listing of the corporate donors.
     */
    public function index()
    {
        $campaigns = Campaign::where('status', 'approved')->get();
        return view('v1.admin.pages.corporate_donors.index', compact('campaigns'));
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
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-info btn-allocate" data-id="' . $row->id . '" data-name="' . $row->name . '">Allocate Funds</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
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
