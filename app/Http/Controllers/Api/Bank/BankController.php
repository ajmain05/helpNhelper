<?php

namespace App\Http\Controllers\Api\Bank;

use App\Http\Controllers\Controller;
use App\Models\User\UserBank;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BankController extends Controller
{
    public function index()
    {
        try {
            $banks = UserBank::where('user_id', auth()->user()->id)
                ->latest()->get();

            return response()->json([
                'data' => $banks,
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

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
        try {

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

            return response()->json([
                'message' => 'Bank details added successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
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
        try {

            $userBank = UserBank::findOrFail($id);
            $userBank->update($validatedData);

            return response()->json([
                'message' => 'Bank details updated successfully.',
            ], 200);
        } catch (ModelNotFoundException) {

            return response()->json([
                'message' => 'Data not found',
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $userBank = UserBank::where('user_id', Auth::id())->findOrFail($id);
            $userBank->delete();

            return response()->json([
                'message' => 'Bank details deleted successfully.',
            ], 200);
        } catch (ModelNotFoundException) {

            return response()->json([
                'message' => 'Data not found',
            ], 500);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
