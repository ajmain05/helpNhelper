<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorporateDeposit;
use App\Models\CorporateWallet;
use App\Notifications\ChequeDepositStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ChequeDepositController extends Controller
{
    /**
     * List all offline/cheque deposit requests (for admin review).
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'under_review');

        $deposits = CorporateDeposit::with('user')
            ->where('method', 'offline')
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20);

        $pendingCount = CorporateDeposit::where('method', 'offline')
            ->where('status', 'under_review')
            ->count();

        return view('v1.admin.pages.cheque_deposits.index', compact('deposits', 'status', 'pendingCount'));
    }

    /**
     * Admin manually adds a cheque deposit for a corporate donor.
     * (Direct credit – no Flutter submission required.)
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'amount'     => 'required|numeric|min:1',
            'cheque_no'  => 'required|string|max:100',
            'bank_name'  => 'required|string|max:100',
            'cheque_image' => 'nullable|image|max:4096',
            'admin_note' => 'nullable|string|max:500',
        ]);

        $imagePath = null;
        if ($request->hasFile('cheque_image')) {
            $imagePath = $request->file('cheque_image')->store('cheque_deposits', 'public');
        }

        DB::beginTransaction();
        try {
            $deposit = CorporateDeposit::create([
                'user_id'      => $request->user_id,
                'amount'       => $request->amount,
                'method'       => 'offline',
                'transaction_id' => 'CHQ-' . strtoupper(uniqid()),
                'status'       => 'completed',    // Admin-added → directly completed
                'cheque_no'    => $request->cheque_no,
                'bank_name'    => $request->bank_name,
                'cheque_image' => $imagePath,
                'admin_note'   => $request->admin_note,
            ]);

            // Credit wallet immediately
            $wallet = CorporateWallet::firstOrCreate(
                ['user_id' => $request->user_id],
                ['total_deposited' => 0, 'balance' => 0]
            );
            $wallet->total_deposited += $request->amount;
            $wallet->balance         += $request->amount;
            $wallet->save();

            DB::commit();

            // Notify donor
            $deposit->user->notify(new ChequeDepositStatusNotification('completed', $request->amount, $request->admin_note));

            return redirect()->back()->with('success', 'Cheque deposit recorded and wallet credited successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Admin approves a donor-submitted cheque deposit request.
     */
    public function approve(Request $request, int $id)
    {
        $deposit = CorporateDeposit::where('method', 'offline')
            ->where('status', 'under_review')
            ->findOrFail($id);

        DB::beginTransaction();
        try {
            $deposit->status     = 'completed';
            $deposit->admin_note = $request->input('admin_note');
            $deposit->save();

            $wallet = CorporateWallet::firstOrCreate(
                ['user_id' => $deposit->user_id],
                ['total_deposited' => 0, 'balance' => 0]
            );
            $wallet->total_deposited += $deposit->amount;
            $wallet->balance         += $deposit->amount;
            $wallet->save();

            DB::commit();

            $deposit->user->notify(new ChequeDepositStatusNotification('completed', $deposit->amount, $deposit->admin_note));

            return response()->json(['success' => true, 'message' => 'Deposit approved and wallet credited.', 'new_balance' => $wallet->balance]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Admin rejects a donor-submitted cheque deposit request.
     */
    public function reject(Request $request, int $id)
    {
        $request->validate(['admin_note' => 'required|string|max:500']);

        $deposit = CorporateDeposit::where('method', 'offline')
            ->where('status', 'under_review')
            ->findOrFail($id);

        $deposit->status     = 'rejected';
        $deposit->admin_note = $request->admin_note;
        $deposit->save();

        $deposit->user->notify(new ChequeDepositStatusNotification('rejected', $deposit->amount, $deposit->admin_note));

        return response()->json(['success' => true, 'message' => 'Deposit request rejected.']);
    }
}
