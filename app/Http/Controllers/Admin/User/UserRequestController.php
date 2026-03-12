<?php

namespace App\Http\Controllers\Admin\User;

use App\Enums\Donor\DonorFile;
use App\Enums\Seeker\SeekerFile;
use App\Enums\User\Status;
use App\Enums\User\Type;
use App\Enums\User\UserRequestFile;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\District;
use App\Models\Division;
use App\Models\Upazila;
use App\Models\User;
use App\Rules\SameOrUniqueEmail;
use App\Rules\SameOrUniqueMobile;
use App\Traits\HasFiles;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class UserRequestController extends Controller
{
    use HasFiles;

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index($type)
    {
        match ($type) {
            'donors' => $userRequestType = 'donor',
            'seekers' => $userRequestType = 'seeker',
            'volunteers' => $userRequestType = 'volunteer',
            'organizations' => $userRequestType = 'organization',
            default => $userRequestType = '',
        };

        return view('v1.admin.pages.user-requests.index', compact('type', 'userRequestType'));
    }

    /**
     * data for datatable ajax request
     *
     * @return mixed
     */
    public function getUserRequestsDatatableAjax($type, Request $request)
    {
        // match ($type) {
        //     'donors' => $userRequestType = 'donor',
        //     'seekers' => $userRequestType = 'seeker',
        //     'volunteers' => $userRequestType = 'volunteer',
        //     'organizations' => $userRequestType = 'organization',
        //     default => $userRequestType = '',
        // };
        // return $type;
        $userRequests = User::where(function ($query) use ($type) {
            $query->where('type', $type === Type::Donor->value ? Type::CorporateDonor->value : null)
                ->orWhere('type', $type);
        })
            ->where('status', Status::Pending->value)
            ->where(function ($query) use ($request) {
                if ($request->search['value']) {
                    $query->where('sid', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('name', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('type', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('email', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('mobile', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('created_at', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('present_address', 'like', '%'.$request->search['value'].'%');
                }
            })
            ->latest();

        return Datatables::of($userRequests)
            ->addColumn('action', function ($userRequest) {
                $markup = '';
                if ($userRequest->status == Status::Pending->value) {
                    $markup .= '<a href="'.route('admin.user-request.edit', [$userRequest->type, $userRequest->id]).'" class="btn btn-secondary m-1">Edit</a>';
                    $markup .= '<a href="'.route('admin.user-request.update-status', $userRequest->id).'" class="btn btn-success m-1">Approve</a>';
                    $markup .= '<a href="#" onclick="deleteUserRequest('.$userRequest->id.')" class="btn btn-danger m-1"> Delete</a>';
                }

                return $markup;
            })
            ->editColumn('created_at', function ($userRequests) {
                return $userRequests->created_at ?? 'N/A';
            })
            ->editColumn('sid', function ($userRequest) {
                return $userRequest?->sid ?? 'N/A';
            })
            ->editColumn('status', function ($userRequest) {
                $markup = '';
                $markup .= $userRequest->status == Status::Approved->value ? '<span class="badge badge-success m-1">' : '<span class="badge badge-danger m-1">';
                $markup .= $userRequest->status == Status::Approved->value ? Status::Approved->value : Status::Pending->value;
                $markup .= '</span>';

                return $markup;
            })
            ->editColumn('photo', function ($userRequest) {
                return $userRequest->photo ? '<img src="'.asset($userRequest->photo).'" alt="Profile Image">' : 'N/A';
            })
            ->rawColumns(['photo', 'sid', 'action', 'status', 'created_at'])
            ->setFilteredRecords($userRequests->count())
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function edit($type, $id)
    {

        $userRequest = User::find($id);
        $userRequestType = match ($type) {
            'donor' => 'Donor',
            'seeker' => 'Seeker',
            'volunteer' => 'Volunteer',
            'corporate-donor' => 'Corporate Donor',
            'organization' => 'Organization',
            default => '',
        };

        if ($userRequestType == 'Donor') {
            $userRequestType = match ($userRequest->type) {
                'donor' => 'Donor',
                'seeker' => 'Seeker',
                'volunteer' => 'Volunteer',
                'corporate-donor' => 'Corporate Donor',
                'organization' => 'Organization',
                default => '',
            };
        }

        $divisions = Division::all();
        $districts = District::all();
        $upazillas = Upazila::all();
        $countries = Country::all();
        // if ($userRequest->status) {
        //     return redirect()->back()->with('error', 'User Request Already Approved');
        // }

        return view('v1.admin.pages.user-requests.edit', compact('userRequest', 'userRequestType', 'type', 'divisions', 'districts', 'upazillas', 'countries'));
    }

    /**
     * update status of the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function updateStatus($id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->status = Status::Approved->value;
            $user->save();
            DB::commit();

            return redirect()->back()->with('success', 'User Request Approved Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error Occurred! | '.$th->getMessage());
        }

    }

    // protected function addUserData($userRequest)
    // {
    //     $user = new User();
    //     $user->name = $userRequest->name;
    //     $user->email = $userRequest->email;
    //     $user->mobile = $userRequest->mobile;
    //     $user->save();
    //     $authFile = $userRequest->getFirstMedia(UserRequestFile::AUTH_FILE->value);
    //     $profileImage = $userRequest->getFirstMedia(UserRequestFile::PROFILE_IMG->value);
    //     if ($userRequest->type == 'donors') {
    //         $user->assignRole('donor');
    //         $user->donor()->create([
    //             'country' => $userRequest->country ?? null,
    //             'permanent_address' => $userRequest->permanent_address ?? null,
    //             'present_address' => $userRequest->present_address ?? null,
    //         ]);
    //         if ($authFile) {
    //             $authFile->copy($user->donor(), DonorFile::AUTH_FILE->value);
    //         }
    //         if ($profileImage) {
    //             $profileImage->copy($user->donor(), DonorFile::PROFILE_IMG->value);
    //         }

    //     }
    //     if ($userRequest->type == 'seekers') {
    //         $user->assignRole('seeker');
    //         $seeker = $user->seeker()->create([
    //             'country' => $userRequest->country,
    //             'permanent_address' => $userRequest->permanent_address,
    //             'present_address' => $userRequest->present_address,
    //         ]);
    //         if ($authFile) {
    //             $authFile->copy($seeker, SeekerFile::AUTH_FILE->value);
    //         }
    //         if ($profileImage) {
    //             $profileImage->copy($seeker, SeekerFile::PROFILE_IMG->value);
    //         }
    //     }
    //     if ($userRequest->type == 'volunteers') {
    //         $user->assignRole('volunteer');
    //         $volunteer = $user->volunteer()->create([
    //             'country' => $userRequest->country,
    //             'permanent_address' => $userRequest->permanent_address,
    //             'present_address' => $userRequest->present_address,
    //         ]);
    //         if ($authFile) {
    //             $authFile->copy($volunteer, SeekerFile::AUTH_FILE->value);
    //         }
    //         if ($profileImage) {
    //             $profileImage->copy($volunteer, SeekerFile::PROFILE_IMG->value);
    //         }
    //     }

    //     return $user;
    // }

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
            'fb_link' => ['nullable'],
            'permanent_address' => ['required_if:type,seeker,volunteer', 'string', 'nullable'],
            'present_address' => ['required_if:type,seeker,volunteer', 'string', 'nullable'],
            'office_address' => ['required_if:type,organization', 'string', 'nullable'],
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
            $userRequest->fb_link = $request->fb_link ?? null;
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
            if ($request->type == Type::Organization->value) {
                if (isset($request->office_address)) {
                    $userRequest->office_address = $request->office_address;
                }
                if (isset($request->org_reg_type)) {
                    $userRequest->org_reg_type = $request->org_reg_type;
                }
                if ($request->org_reg_type === 'registered') {
                    $userRequest->reg_body = $request->reg_body ?? null;
                    $userRequest->reg_no = $request->reg_no ?? null;
                    // certificate image update 
                    if ($request->file('cert_image')) {
                        $certPath = $this->storeFile('user', $request->file('cert_image'), 'cert');
                        $userRequest->cert_image = $certPath ?? null;
                    }
                } else {
                    $userRequest->years_of_op = $request->years_of_op ?? null;
                    $userRequest->beneficiaries_count = $request->beneficiaries_count ?? null;
                    $userRequest->working_sectors = $request->working_sectors ?? null;
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

            return redirect()->back()->with('success', ucfirst($request->type).' Request Updated Successfully');
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
        try {
            $userRequest = User::findOrFail($request->id);
            $userRequest->delete();

            return new JsonResponse(['message' => 'User Request Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {

            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
