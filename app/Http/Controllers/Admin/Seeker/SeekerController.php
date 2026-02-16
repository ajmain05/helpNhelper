<?php

namespace App\Http\Controllers\Admin\Seeker;

use App\Enums\User\Status;
use App\Enums\User\Type;
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

class SeekerController extends Controller
{
    use HasFiles;

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('v1.admin.pages.seekers.index');
    }

    /**
     * data for datatable ajax request
     *
     * @return mixed
     */
    public function getSeekersDatatableAjax(Request $request)
    {
        $seekers = User::where('type', Type::Seeker->value)->where('status', Status::Approved->value)
            ->when($request->search['value'] != null, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('sid', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('name', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('email', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('mobile', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('present_address', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('created_at', 'like', '%'.$request->search['value'].'%');
                });
            })
            ->latest();

        return Datatables::of($seekers)
            // ->editColumn('user.name', function ($seeker) {
            //     return $seeker->user->name;
            // })
            // ->editColumn('user.email', function ($seeker) {
            //     return $seeker->user->email;
            // })
            // ->editColumn('user.mobile', function ($seeker) {
            //     return $seeker->user->mobile;
            // })
            ->addColumn('action', function ($seeker) {
                $markup = '';
                $markup .= '<a href="'.route('admin.seeker.edit', [$seeker->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="#" onclick="deleteSeeker('.$seeker->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->editColumn('sid', function ($seeker) {
                return $seeker->sid ?? 'N/A';
            })
            ->editColumn('image', function ($seeker) {
                return $seeker->photo ? '<img src="'.asset($seeker->photo).'" alt="Profile Image">' : 'N/A';
            })
            ->editColumn('created_at', function ($seeker) {
                return $seeker->created_at ?? 'N/A';
            })
            // ->rawColumns(['action', 'user.name', 'user.email', 'user.mobile'])
            ->setFilteredRecords($seekers->count())
            ->rawColumns(['image', 'action', 'created_at'])
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

        return view('v1.admin.pages.seekers.edit', compact('userRequest', 'divisions', 'districts', 'upazillas', 'countries'));
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

            return redirect()->back()->with('success', 'Seeker Profile Updated Successfully');
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
            $seeker = User::findOrFail($request->id);
            $seeker->delete();
            DB::commit();

            return new JsonResponse(['message' => 'Seeker Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();

            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
