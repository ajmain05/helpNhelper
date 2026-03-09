<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign\Campaign;
use App\Models\CorporateAllocation;
use App\Models\CorporateDeposit;
use App\Models\CorporateWallet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CorporateWalletController extends Controller
{
    /**
     * Get the authenticated Corporate Donor's wallet history.
     */
    public function getWalletHistory(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->type !== 'corporate-donor') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only Corporate Donors can access this feature.',
            ], Response::HTTP_FORBIDDEN);
        }

        $wallet = CorporateWallet::firstOrCreate(
            ['user_id' => $user->id],
            ['total_deposited' => 0, 'balance' => 0]
        );

        $allocations = CorporateAllocation::with('campaign')
            ->where('user_id', $user->id)
            ->orderBy('allocated_at', 'desc')
            ->get();

        $formattedAllocations = $allocations->map(function ($allocation) {
            return [
                'id' => $allocation->id,
                'amount' => $allocation->amount,
                'allocated_at' => $allocation->allocated_at,
                'campaign' => [
                    'id' => $allocation->campaign->id ?? null,
                    'title' => $allocation->campaign->title ?? 'Unknown Campaign',
                    'image' => $allocation->campaign->image ? asset($allocation->campaign->image) : null,
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'wallet' => [
                'total_deposited' => $wallet->total_deposited,
                'balance' => $wallet->balance,
            ],
            'allocations' => $formattedAllocations,
        ]);
    }

    /**
     * Admin functionality to record a manual deposit from a Corporate Donor.
     * (In a real app, this might be restricted to an Admin middleware or panel)
     */
    public function recordDeposit(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $user = User::findOrFail($request->user_id);

        if ($user->type !== 'corporate-donor') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a corporate donor.',
            ], Response::HTTP_BAD_REQUEST);
        }

        // 1. Record the manual offline deposit
        $deposit = CorporateDeposit::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'method' => 'offline',
            'transaction_id' => 'OFFLINE-' . strtoupper(Str::random(10)),
            'status' => 'completed',
        ]);

        // 2. Add to wallet balance
        $wallet = CorporateWallet::firstOrCreate(
            ['user_id' => $user->id],
            ['total_deposited' => 0, 'balance' => 0]
        );

        $wallet->total_deposited += $request->amount;
        $wallet->balance += $request->amount;
        $wallet->save();

        return response()->json([
            'success' => true,
            'message' => 'Offline deposit recorded successfully.',
            'deposit' => $deposit,
            'wallet' => $wallet,
        ]);
    }

    /**
     * Admin functionality to allocate funds from a Corporate Wallet to a Campaign.
     */
    public function recordAllocation(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'campaign_id' => ['required', 'exists:campaigns,id'],
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $wallet = CorporateWallet::where('user_id', $request->user_id)->first();

        if (!$wallet || $wallet->balance < $request->amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient wallet balance.',
            ], Response::HTTP_BAD_REQUEST);
        }

        // Deduct from wallet
        $wallet->balance -= $request->amount;
        $wallet->save();

        // Create the Allocation record
        $allocation = CorporateAllocation::create([
            'user_id' => $request->user_id,
            'campaign_id' => $request->campaign_id,
            'amount' => $request->amount,
            'allocated_at' => Carbon::now(),
        ]);

        // Note: For a complete system, we might also want to update the Campaign's `raised_amount`
        $campaign = Campaign::findOrFail($request->campaign_id);
        if ($campaign) {
            // Check if raised_amount exists, adjust as per schema
            if (isset($campaign->raised_amount)) {
                $campaign->raised_amount += $request->amount;
                $campaign->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Funds allocated to campaign successfully.',
            'allocation' => $allocation,
            'remaining_balance' => $wallet->balance,
        ]);
    }
}
