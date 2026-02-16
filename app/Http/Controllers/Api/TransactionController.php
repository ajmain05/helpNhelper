<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index()
    {
        try {
            $transactions = Transaction::where('volunteer_id', auth()->user()->id)
                ->with([
                    'bankInfo',
                    'bankAccountInfo',
                    'userBank',
                    'invoice',
                    'campaignInfo',
                    'transactionCategory',
                    'transactionMode',
                ])
                ->latest()->get();

            return response()->json([
                'data' => $transactions,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function statusUpdate(Request $request, $transactionId)
    {
        $request->validate([
            'receive_status' => ['required', 'string', Rule::in(['accepted', 'declined'])],
        ]);
        try {

            $transaction = Transaction::findOrFail($transactionId);

            if ($transaction->volunteer_id != Auth::user()->id) {
                return response()->json([
                    'error' => 'You are not authorized to accept or decline this transaction.',
                ], 403);
            }
            $transaction->update([
                'receive_status' => $request->receive_status,
            ]);

            return response()->json([
                'message' => "Transaction {$request->receive_status} successfully.",
            ], 200);
        } catch (ModelNotFoundException) {
            return response()->json([
                'message' => 'No data found',
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

    }
}
