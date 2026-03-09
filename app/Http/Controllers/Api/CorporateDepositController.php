<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\CorporateDeposit;
use App\Models\CorporateWallet;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CorporateDepositController extends Controller
{
    /**
     * Initiate the SSLCommerz payment for a corporate wallet deposit.
     */
    public function initiateDeposit(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:10'],
        ]);

        $user = $request->user();

        if ($user->type !== 'corporate-donor') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only Corporate Donors can deposit directly to the wallet.',
            ], Response::HTTP_FORBIDDEN);
        }

        $tran_id = Str::uuid();

        // 1. Create a pending deposit record
        CorporateDeposit::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'method' => 'sslcommerz',
            'transaction_id' => $tran_id,
            'status' => 'pending',
        ]);

        // 2. Prepare SSLCommerz Data
        $post_data = [];
        $post_data['total_amount'] = $request->amount;
        $post_data['currency'] = 'BDT';
        $post_data['tran_id'] = $tran_id;

        // Mock customer info (can pull from $user if available)
        $post_data['cus_name'] = $user->name ?? 'Corporate Donor';
        $post_data['cus_email'] = $user->email ?? 'corporate@example.com';
        $post_data['cus_add1'] = 'Dhaka';
        $post_data['cus_add2'] = '';
        $post_data['cus_city'] = '';
        $post_data['cus_state'] = '';
        $post_data['cus_postcode'] = '';
        $post_data['cus_country'] = 'Bangladesh';
        $post_data['cus_phone'] = $user->mobile ?? '01XXXXXXXXX';
        $post_data['cus_fax'] = '';

        // Shipment
        $post_data['ship_name'] = $user->name ?? 'Corporate Donor';
        $post_data['ship_add1'] = 'Dhaka';
        $post_data['ship_add2'] = 'Dhaka';
        $post_data['ship_city'] = 'Dhaka';
        $post_data['ship_state'] = 'Dhaka';
        $post_data['ship_postcode'] = '1000';
        $post_data['ship_phone'] = '';
        $post_data['ship_country'] = 'Bangladesh';
        $post_data['shipping_method'] = 'NO';
        
        $post_data['product_name'] = 'Corporate Wallet Deposit';
        $post_data['product_category'] = 'Deposit';
        $post_data['product_profile'] = 'general';
        
        $post_data['value_a'] = $user->id; // Pass user ID to IPN

        $sslc = new SslCommerzNotification();
        $payment_options = json_decode($sslc->makePayment($post_data), true);

        if (isset($payment_options['status']) && $payment_options['status'] == 'failed') {
            return response()->json([
                'success' => false,
                'message' => 'Payment initiation failed: ' . ($payment_options['failedreason'] ?? 'Unknown error'),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment initiated.',
            'redirect_url' => $payment_options['data'], 
        ], Response::HTTP_OK);
    }

    /**
     * SSLCommerz Success IPN webhook.
     */
    public function success(Request $request)
    {
        try {
            $tran_id = $request->input('tran_id');
            $amount = $request->input('amount');
            $currency = $request->input('currency');

            $sslc = new SslCommerzNotification();
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                DB::beginTransaction();

                $deposit = CorporateDeposit::where('transaction_id', $tran_id)
                                           ->where('status', 'pending')
                                           ->first();

                if ($deposit) {
                    // Update Deposit Status
                    $deposit->status = 'completed';
                    $deposit->save();

                    // Update/Create Wallet Balance
                    $wallet = CorporateWallet::firstOrCreate(
                        ['user_id' => $deposit->user_id],
                        ['total_deposited' => 0, 'balance' => 0]
                    );

                    $wallet->total_deposited += $deposit->amount;
                    $wallet->balance += $deposit->amount;
                    $wallet->save();

                    DB::commit();
                } else {
                    DB::rollBack();
                }

                return response("Deposit Successful. You can close this page.", 200);
            } else {
                DB::rollBack();
                return response("Payment Validation Failed.", 400);
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            return response("Error processing payment: " . $th->getMessage(), 500);
        }
    }

    /**
     * SSLCommerz Cancel IPN webhook.
     */
    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        CorporateDeposit::where('transaction_id', $tran_id)->update(['status' => 'cancelled']);
        return response("Deposit Cancelled.", 200);
    }

    /**
     * SSLCommerz Fail IPN webhook.
     */
    public function failed(Request $request)
    {
        $tran_id = $request->input('tran_id');
        CorporateDeposit::where('transaction_id', $tran_id)->update(['status' => 'failed']);
        return response("Deposit Failed.", 200);
    }
}
