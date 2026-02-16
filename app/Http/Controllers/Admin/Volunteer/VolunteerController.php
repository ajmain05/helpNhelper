<?php

namespace App\Http\Controllers\Admin\Volunteer;

use App\Enums\User\Status;
use App\Enums\User\Type;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\District;
use App\Models\Division;
use App\Models\Transaction\Transaction;
use App\Models\Upazila;
use App\Models\User;
use App\Rules\SameOrUniqueEmail;
use App\Rules\SameOrUniqueMobile;
use App\Traits\HasFiles;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class VolunteerController extends Controller
{
    use HasFiles;

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('v1.admin.pages.volunteers.index');
    }

    /**
     * data for datatable ajax request
     *
     * @return mixed
     */
    public function getVolunteersDatatableAjax(Request $request)
    {
        $volunteers = User::where('type', Type::Volunteer->value)->where('status', Status::Approved->value)
            ->where(function ($query) use ($request) {
                if ($request->search['value']) {
                    $query->where('sid', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('name', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('email', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('mobile', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('present_address', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('created_at', 'like', '%'.$request->search['value'].'%');
                }
            })
            ->latest();

        return Datatables::of($volunteers)
            ->addColumn('action', function ($volunteer) {
                $markup = '';
                $markup .= '<a href="'.route('admin.volunteer.show', [$volunteer->id]).'" class="btn btn-primary m-1">Show</a>';
                $markup .= '<a href="'.route('admin.volunteer.edit', [$volunteer->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="#" onclick="deleteVolunteer('.$volunteer->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->editColumn('sid', function ($volunteer) {
                return $volunteer->sid ?? 'N/A';
            })
            ->editColumn('photo', function ($volunteer) {
                return $volunteer->photo ? '<img src="'.asset($volunteer->photo).'" alt="Profile Image">' : 'N/A';
            })
            ->editColumn('created_at', function ($volunteer) {
                return $volunteer->created_at ?? 'N/A';
            })
            // ->rawColumns(['action', 'user.name', 'user.email', 'user.mobile'])
            ->setFilteredRecords($volunteers->count())
            ->rawColumns(['photo', 'action', 'created_at'])
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
        $divisions = Division::all();
        $districts = District::all();
        $upazillas = Upazila::all();
        $countries = Country::all();

        return view('v1.admin.pages.volunteers.edit', compact('userRequest', 'divisions', 'districts', 'upazillas', 'countries'));
    }

    public function show($id)
    {
        $userRequest = User::with([
            'userBanks' => function ($q) {
                $q->latest();
            },
        ])->findOrFail($id);

        $transactions = Transaction::where('volunteer_id', $id)->latest()->get();

        return view('v1.admin.pages.volunteers.show', compact('userRequest', 'transactions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return mixed
     */
    public function update(Request $request)
    {
        $request->validate([
            'type' => ['required', 'string', Rule::in([Type::Donor->value, Type::Volunteer->value, Type::Seeker->value])],
            'name' => ['required', 'string'],
            'email' => ['required_without:mobile', 'email', 'nullable', new SameOrUniqueEmail($request->id)],
            'mobile' => ['required_without:email', 'string', 'nullable', new SameOrUniqueMobile($request->id)],
            'auth_file' => ['file', 'mimetypes:image/jpeg,image/png,application/pdf', 'nullable'],
            'upazila' => ['required_if:type,seeker,volunteer'],
            'fb_link' => ['nullable'],
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
            if ($request->file('photo')) {
                $photoPath = $this->storeFile('user', $request->file('photo'), 'photo');
                $userRequest->photo = $photoPath ?? null;
            }
            if ($request->file('auth_file')) {
                $authPath = $this->storeFile('user', $request->file('auth_file'), 'auth');
                $userRequest->auth_file = $authPath ?? null;
            }
            $userRequest->save();

            return redirect()->back()->with('success', 'Volunteer Profile Updated Successfully');
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

            return new JsonResponse(['message' => 'Volunteer Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {

            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
