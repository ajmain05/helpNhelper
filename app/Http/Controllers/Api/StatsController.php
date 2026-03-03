<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign\Campaign;
use App\Models\Donation;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Response;

class StatsController extends Controller
{
    public function index()
    {
        try {
            // Total money donated (income transactions only)
            $totalDonated = Transaction::where('type', 'income')->sum('amount');

            // Total number of donations received
            $totalDonationsReceived = Donation::count();

            // Total number of campaigns
            $totalCampaigns = Campaign::count();

            // Total successful (completed) campaigns
            $successfulCampaigns = Campaign::where('status', 'completed')->count();

            return response()->json([
                'data' => [
                    'total_donated'             => (int) $totalDonated,
                    'total_donations_received'  => $totalDonationsReceived,
                    'total_campaigns'           => $totalCampaigns,
                    'successful_campaigns'      => $successfulCampaigns,
                ],
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
