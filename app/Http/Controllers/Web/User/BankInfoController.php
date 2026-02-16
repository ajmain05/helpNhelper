<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\User\UserBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BankInfoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', Rule::in(['mfs', 'bank'])],
            'bkash' => [
                'nullable',
                Rule::requiredIf($request->type === 'mfs' && ! $request->nagad),
            ],
            'nagad' => [
                'nullable',
                Rule::requiredIf($request->type === 'mfs' && ! $request->bkash),
            ],
            'bank_name' => 'nullable|required_if:type,bank|string|max:255',
            'branch_name' => 'nullable|required_if:type,bank|string|max:255',
            'routing_number' => 'nullable|required_if:type,bank',
            'holder_name' => 'nullable|required_if:type,bank|string|max:255',
            'account_number' => 'nullable|required_if:type,bank',
        ]);

        UserBank::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'bkash' => $request->bkash ?? null,
            'nagad' => $request->nagad ?? null,
            'bank_name' => $request->bank_name ?? null,
            'branch_name' => $request->branch_name ?? null,
            'routing_number' => $request->routing_number ?? null,
            'holder_name' => $request->holder_name ?? null,
            'account_number' => $request->account_number ?? null,
        ]);

        return back()->with('success', 'Bank details added successfully.');

    }

    public function destroy($userBankId)
    {
        $bankInfo = UserBank::findOrFail($userBankId);
        if ($bankInfo->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'You are not authorized to delete this bank info.');
        }
        $bankInfo->delete();

        return redirect()->back()->with('success', 'Bank info deleted successfully.');
    }
}
