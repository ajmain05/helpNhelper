<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization\OrganizationApplication;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\HasFiles;

class OrganizationApplicationController extends Controller
{
    use HasFiles;

    /**
     * Store a newly created application.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'seeker_name' => 'required|string|max:255',
            'seeker_location' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'payment_account' => 'required|string',
            'cert_image' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get service charge from settings if available, else 7%
            $serviceChargePct = GeneralSetting::get('org_service_charge', 7.00);

            $documentPath = null;
            if ($request->hasFile('cert_image')) {
                $documentPath = $this->storeFile('org_applications', $request->file('cert_image'), 'doc');
            }

            $application = OrganizationApplication::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'requested_amount' => $request->target_amount,
                'seeker_name' => $request->seeker_name,
                'seeker_location' => $request->seeker_location,
                'payment_method' => $request->payment_method,
                'payment_account' => $request->payment_account,
                'cert_image' => $documentPath,
                'status' => 'pending',
                'service_charge_pct' => $serviceChargePct,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Application submitted successfully',
                'data' => $application
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a list of applications for the authenticated organization.
     */
    public function index()
    {
        try {
            $applications = OrganizationApplication::where('user_id', auth()->id())
                ->latest()
                ->get();
                
            $applications->map(function ($app) {
                $app->progress = $app->progressAttribute;
                return $app;
            });

            return response()->json([
                'status' => 'success',
                'data' => $applications
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
