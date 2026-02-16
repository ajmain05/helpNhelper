<?php

namespace App\Http\Controllers\Web;

use App\Enums\Campaign\Status;
use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Bank\BankAccount;
use App\Models\Campaign\Campaign;
use App\Models\Donation;
use App\Models\Invoice\Invoice;
use App\Models\Transaction\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function makePayment(Request $request)
    {
        // From here
        $isApp = $request->query('is_app', false);
        $request->validate([
            'campaign_id' => ['required', 'exists:campaigns,id'],
            'phone' => ['nullable', 'numeric'],
            'amount' => ['required', 'numeric', 'min:10'],
        ]);

        $campaign = Campaign::find($request->campaign_id);
        if ($campaign->status == Status::Finished->value) {
            return redirect()->to('/campaign/'.$request->campaign_id)->with('error', 'The campaign is over');
        } elseif ($campaign->status != Status::Ongoing->value) {
            return redirect()->to('/campaign/'.$request->campaign_id)->with('error', 'The campaign is unavailable for donations');
        }

        $post_data = [];
        $post_data['total_amount'] = $request->amount; // You cant not pay less than 10
        $post_data['currency'] = 'BDT';
        $post_data['tran_id'] = Str::uuid(); // tran_id must be unique

        // CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Hafizul';
        $post_data['cus_email'] = 'Hafizul@gmail.com';
        $post_data['cus_add1'] = 'Chittagong';
        $post_data['cus_add2'] = '';
        $post_data['cus_city'] = '';
        $post_data['cus_state'] = '';
        $post_data['cus_postcode'] = '';
        $post_data['cus_country'] = 'Bangladesh';
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = '';

        // SHIPMENT INFORMATION
        $post_data['ship_name'] = 'Hafizul';
        $post_data['ship_add1'] = 'Chittagong';
        $post_data['ship_add2'] = 'Chittagong';
        $post_data['ship_city'] = 'Chittagong';
        $post_data['ship_state'] = 'Chittagong';
        $post_data['ship_postcode'] = '4000';
        $post_data['ship_phone'] = '';
        $post_data['ship_country'] = 'Bangladesh';

        $post_data['shipping_method'] = 'NO';
        $post_data['product_name'] = 'helpNhelper';
        $post_data['product_category'] = 'Donation';
        $post_data['product_profile'] = 'general';
        $post_data['value_a'] = $request->campaign_id;
        $post_data['value_b'] = $request->phone;
        $post_data['value_c'] = Auth::user()->id ?? null;

        $sslc = new SslCommerzNotification();
        // initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = json_decode($sslc->makePayment($post_data), true);

        // dd( $payment_options);
        if (($payment_options)['status'] == 'failed') {
            return new JsonResponse(
                [
                    'message' => 'Payment failed: '.$payment_options['failedreason'],
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if ($isApp) {
            return response()->json([
                'message' => 'Payment initiated.',
                'redirect_url' => $payment_options['data'],
            ], Response::HTTP_OK);
        } else {
            return redirect()->to($payment_options['data']);
        }

    }

    public function success(Request $request)
    {
        try {

            $tran_id = $request->input('tran_id');
            $amount = $request->input('amount');
            $currency = $request->input('currency');

            $sslc = new SslCommerzNotification();
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            DB::beginTransaction();
            if ($validation) {
                $donation = new Donation();
                $donation->campaign_id = $request['value_a'];
                $donation->phone = $request['value_b'];
                $donation->amount = $request['currency_amount'];
                $donation->user_id = $request['value_c'];
                $donation->tran_id = $request['tran_id'];

                $paymentDateTime = Carbon::now();

                $invoice = Invoice::create([
                    'campaign_id' => $request['value_a'] ?? null,
                    'status' => 1,
                    'date' => $paymentDateTime ?? null,
                    'created_by' => Auth::id() ?? null,
                ]);

                $invoice->sid = 'IN-'.(100_000 + $invoice->id);
                $invoice->save();

                $transaction = Transaction::create([
                    'receiver_type' => $request['value_c'] != null ? 'donor' : 'anonymous',
                    'date' => $paymentDateTime,
                    'amount' => $request['currency_amount'],
                    'remarks' => null,
                    'status' => 1,
                    'type' => 'income',
                    'sub_type' => 'digital',
                    'campaign_id' => $request['value_a'] ?? null,
                    'transaction_category_id' => null,
                    'transaction_mode_id' => null,
                    'bank_id' => 1,
                    'bank_account_id' => 1,
                    'invoice_id' => $invoice->id ?? null,
                    'donor_id' => Auth::user()->id ?? null,
                    'name' => null,
                    'mobile' => $request['value_b'] ?? null,
                    'volunteer_id' => null,
                    'created_by' => Auth::id() ?? null,
                ]);

                $bankAccount = BankAccount::findOrFail(1);
                $bankAccount->current_balance = $bankAccount->current_balance + $request->amount;
                $bankAccount->save();

                $donation->save();

                DB::commit();

                return redirect()->to('/campaign/'.$request['value_a'])->with('success', 'Thanks for your donation.');
            } else {
                DB::rollBack();

                return redirect()->to('/campaign/'.$request['value_a'])->with('error', 'Failed to make donation.');

            }

        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(
                [
                    'message' => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }

    public function cancel(Request $request)
    {
        return redirect()->to('/campaign/'.$request['value_a'])->with('error', 'Donation process has cancelled.');

    }

    public function failed(Request $request)
    {
        return redirect()->to('/campaign/'.$request['value_a'])->with('error', 'Donation process has failed.');

    }
}
