<?php

namespace App\Http\Controllers;

use App\Models\Invoice\Invoice;
use App\Models\Transaction\Transaction;

class TestController extends Controller
{
    public function test()
    {
        // $transaction = Transaction::find(6);
        // $campaign = $transaction->campaignInfo;
        // $volunteer = $transaction->campaignInfo->seeker_application->volunteers->first();
        // return $volunteer ?? "N/A";
        // $request = (object)[
        //     'search' => [
        //         'value' => null
        //     ],
        //     'type' => 'income'
        // ];
        // $request = json_decode(json_encode($request));
        // $request->search['value'] = null;
        // $invoices = Invoice::with([
        //     'transaction',
        //     'transaction.transactionCategory',
        //     'transaction.donorInfo',
        //     'transaction.volunteerInfo',
        //     'transaction.campaignInfo',
        //     'statusInfo',

        // ])->whereHas('transaction', function ($query) {
        //     $query->where('type', 'income');
        // })->when(true, function ($query) {
        //     $query->where(function ($query) {
        //         $query->whereHas('statusInfo', function ($query) {
        //             $query->where('name', 'like', '%'.'income'.'%');
        //         });
        // ->orWhereHas('transaction', function ($query) use ($request) {
        //     $query->whereHas('campaignInfo', function ($query) use ($request) {
        //         $query->where('title', 'like', '%'.$request->search['value'].'%');
        //     })
        //         ->orWhere('date', 'like', '%'.$request->search['value'].'%')
        //         ->orWhereHas('donorInfo', function ($query) use ($request) {
        //             $query->where('name', 'like', '%'.$request->search['value'].'%');
        //         })
        //         ->orWhere('amount', 'like', '%'.$request->search['value'].'%')
        //         ->orWhereHas('transactionCategory', function ($query) use ($request) {
        //             $query->where('name', 'like', '%'.$request->search['value'].'%');
        //         })
        //         ->orWhere('created_at', 'like', '%'.$request->search['value'].'%');
        // });
        //     });
        // })
        //     ->latest();

        // $invoices = Invoice::with([
        //     'transaction',
        //     'transaction.transactionCategory',
        //     'transaction.donorInfo',
        //     'transaction.volunteerInfo',
        //     'transaction.campaignInfo',
        //     'statusInfo',

        // ]);
        // return $invoices;
    }
}
