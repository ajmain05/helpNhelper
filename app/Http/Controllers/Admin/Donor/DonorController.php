<?php

namespace App\Http\Controllers\Admin\Donor;

use App\Enums\User\Status;
use App\Enums\User\Type;
use App\Http\Controllers\Controller;
use App\Models\Donor\Donor;
use App\Models\User;
use App\Rules\SameOrUniqueEmail;
use App\Rules\SameOrUniqueMobile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Models\CorporateDeposit;
use App\Models\CorporateWallet;
use Illuminate\Support\Str;

class DonorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('v1.admin.pages.donors.index');
    }

    /**
     * data for datatable ajax request
     *
     * @return mixed
     */
    public function getDonorsDatatableAjax(Request $request)
    {
        // $donors = User::with('user')
        //     ->whereHas('user', function ($query) use ($request) {
        //         if ($request->search['value']) {
        //             $query->orWhere('name', 'like', '%'.$request->search['value'].'%')
        //                 ->orWhere('email', 'like', '%'.$request->search['value'].'%')
        //                 ->orWhere('mobile', 'like', '%'.$request->search['value'].'%');
        //         }
        //     })
        //     ->latest();
        $donors = User::where('type', Type::Donor->value)
            ->where('status', Status::Approved->value)
            ->where(function ($query) use ($request) {
                if ($request->search['value']) {
                    $query->where('sid', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('name', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('type', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('email', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('mobile', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('created_at', 'like', '%'.$request->search['value'].'%');
                }
            })
            ->with('corporateWallet')
            ->latest();

        // return Datatables::of($donors)
        //     ->editColumn('user.name', function ($donor) {
        //         return $donor->user->name;
        //     })
        //     ->editColumn('user.email', function ($donor) {
        //         return $donor->user->email;
        //     })
        //     ->editColumn('user.mobile', function ($donor) {
        //         return $donor->user->mobile;
        //     })
        //     ->editColumn('status', function ($donor) {
        //         $markup = '';
        //         $markup .= $donor->status ? '<span class="badge badge-success m-1">' : '<span class="badge badge-warning m-1">';
        //         $markup .= $donor->status ? 'Approved' : 'Pending';
        //         $markup .= '</span>';

        //         return $markup;
        //     })
        //     ->addColumn('action', function ($donor) {
        //         $markup = '';
        //         $markup .= '<a href="'.route('admin.donor.edit', [$donor->id]).'" class="btn btn-secondary m-1">Edit</a>';
        //         $markup .= '<a href="#" onclick="deleteDonor('.$donor->id.')" class="btn btn-danger m-1"> Delete</a>';

        //         return $markup;
        //     })
        //     ->rawColumns(['action', 'user.name', 'user.email', 'user.mobile', 'status'])
        //     ->setFilteredRecords($donors->count())
        //     ->make(true);

        return Datatables::of($donors)
            ->editColumn('users.sid', function ($donor) {
                return $donor->sid ?? 'N/A';
            })
            ->editColumn('users.name', function ($donor) {
                return $donor->name;
            })
            ->editColumn('users.photo', function ($donor) {
                return $donor->photo ? '<img src="'.asset($donor->photo).'" alt="Profile Image">' : 'N/A';
            })
            ->editColumn('users.type', function ($donor) {
                return $donor->type;
            })
            ->editColumn('users.email', function ($donor) {
                return $donor->email;
            })
            ->editColumn('users.mobile', function ($donor) {
                return $donor->mobile;
            })
            ->editColumn('users.status', function ($donor) {
                $markup = '';
                $markup .= $donor->status ? '<span class="badge badge-success m-1">' : '<span class="badge badge-warning m-1">';
                $markup .= $donor->status ? 'Approved' : 'Pending';
                $markup .= '</span>';

                return $markup;
            })
            ->addColumn('wallet', function ($donor) {
                if ($donor->type === Type::CorporateDonor->value) {
                    return $donor->corporateWallet ? '৳ ' . number_format($donor->corporateWallet->balance, 2) : '৳ 0.00';
                }
                return '-';
            })
            ->editColumn('created_at', function ($donor) {
                return $donor->created_at ?? 'N/A';
            })
            ->addColumn('action', function ($donor) {
                $markup = '';
                if ($donor->type === Type::CorporateDonor->value) {
                    $escapedName = htmlspecialchars($donor->name, ENT_QUOTES);
                    $markup .= '<button onclick="openDepositModal('.$donor->id.', \''.$escapedName.'\')" class="btn btn-success m-1"><i class="fas fa-money-check-alt"></i> Deposit</button>';
                }
                $markup .= '<a href="'.route('admin.donor.edit', [$donor->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="#" onclick="deleteDonor('.$donor->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->rawColumns(['users.sid', 'action', 'users.name', 'users.photo', 'users.email', 'users.mobile', 'users.status', 'wallet', 'created_at'])
            ->setFilteredRecords($donors->count())
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function edit($id)
    {
        $userRequest = User::findOrFail($id);

        return view('v1.admin.pages.donors.edit', compact('userRequest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return mixed
     */
    public function update(Request $request)
    {
        $request->validate([
            'type' => ['required', 'string', Rule::in([Type::Donor->value, Type::Volunteer->value, Type::Seeker->value, Type::CorporateDonor->value, Type::Organization->value])],
            'name' => ['required', 'string'],
            'email' => ['required_without:mobile', 'email', 'nullable', new SameOrUniqueEmail($request->id)],
            'mobile' => ['required_without:email', 'string', 'nullable', new SameOrUniqueMobile($request->id)],
            'auth_file' => ['file', 'mimetypes:image/jpeg,image/png,application/pdf', 'nullable'],
            'upazila' => ['required_if:type,seeker,volunteer'],
            'permanent_address' => ['required_if:type,seeker,volunteer', 'string', 'nullable'],
            'present_address' => ['required_if:type,seeker,volunteer', 'string', 'nullable'],
            'photo' => ['file', 'mimes:jpeg,png,jpg', 'nullable'],
            'password' => ['nullable', 'min:8'],
            'status' => [Rule::in('pending', 'approved')],
        ]);
        try {
            $userRequest = User::find($request->id);
            $userRequest->name = $request->name;
            $userRequest->email = $request->email ? $request->email : null;
            $userRequest->mobile = $request->mobile ? $request->mobile : null;
            $userRequest->type = $request->type;
            $userRequest->status = $request->status;
            if ($request->type != Type::Donor->value) {
                if (isset($request->upazila)) {
                    $userRequest->upazila_id = $request->upazila ?? null;
                }
                if (isset($request->permanent_address)) {
                    $userRequest->permanent_address = $request->permanent_address ?? null;
                }
                if (isset($request->present_address)) {
                    $userRequest->present_address = $request->present_address ?? null;
                }
            }
            if ($request->file('photo')) {
                $photoPath = $this->storeFile('user', $request->file('photo'), 'photo');
                $userRequest->photo = $photoPath ?? null;
            }
            if ($request->file('auth_file')) {
                $authPath = $this->storeFile('user', $request->file('auth_file'), 'auth');
                $userRequest->auth_file = $authPath ?? null;
            }
            $userRequest->save();

            return redirect()->back()->with('success', 'Donor Profile Updated Successfully');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Error Occurred! | '.$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $donor = User::findOrFail($request->id);
            $donor->delete();
            DB::commit();

            return new JsonResponse(['message' => 'Donor Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();

            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Record a manual Cheque / Offline deposit from the Admin Panel.
     */
    public function recordDepositWeb(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'cheque_number' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();
            $user = User::findOrFail($request->user_id);
            
            if ($user->type !== Type::CorporateDonor->value) {
                return redirect()->back()->with('error', 'Only corporate donors have wallets.');
            }

            // Record offline deposit
            CorporateDeposit::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'method' => 'offline',
                'transaction_id' => $request->cheque_number ? 'CHQ-' . $request->cheque_number : 'OFFLINE-' . strtoupper(Str::random(10)),
                'status' => 'completed',
            ]);

            // Add to wallet balance
            $wallet = CorporateWallet::firstOrCreate(
                ['user_id' => $user->id],
                ['total_deposited' => 0, 'balance' => 0]
            );

            $wallet->total_deposited += $request->amount;
            $wallet->balance += $request->amount;
            $wallet->save();

            DB::commit();
            return redirect()->back()->with('success', 'Cheque Deposit Recorded Successfully. ৳' . number_format($request->amount, 2) . ' added to wallet!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error Occurred! | ' . $th->getMessage());
        }
    }
}
