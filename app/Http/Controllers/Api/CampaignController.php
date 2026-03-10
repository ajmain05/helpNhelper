<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign\Campaign;
use App\Models\Campaign\CampaignCategory;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category_id', null);
        $isFeatured = $request->query('is_featured', null);

        try {
            $campaigns = Campaign::with(['category'])->when($category !== null, function ($q) use ($category) {
                $q->where('category_id', $category);
            })->when($isFeatured == 1, function ($q) use ($isFeatured) {
                $q->where('is_featured', $isFeatured);
            })->latest()->get();

            foreach ($campaigns as $campaign) {
                $transaction = Transaction::where('campaign_id', $campaign->id)->where('type', 'income');
                $campaign->total_donation = $transaction->sum('amount');
                $campaign->total_donors = $transaction->count();
            }

            return response()->json(['data' => $campaigns], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json([
                'message' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function category()
    {
        try {
            $campaignCategory = CampaignCategory::with(['parent_category'])->orderBy('title', 'asc')->get();

            return response()->json(['data' => $campaignCategory], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $campaign = Campaign::with([
                'category',
                'seeker_application.user.upazila.district.division.country',
            ])->findOrFail($id);

            $transaction = Transaction::where('campaign_id', $campaign->id)->where('type', 'income');
            $campaign->total_donation = $transaction->sum('amount');
            $campaign->total_donors = $transaction->count();

            return response()->json(['data' => $campaign], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
