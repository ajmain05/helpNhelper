<?php

namespace App\Http\Controllers\Admin\Organization;

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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('v1.admin.pages.organizations.index');
    }

    /**
     * data for datatable ajax request
     *
     * @return mixed
     */
    public function getOrganizationsDatatableAjax(Request $request)
    {
        $organizations = User::where('type', Type::Organization->value)->where('status', Status::Approved->value)
            ->when($request->search['value'] != null, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('sid', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('name', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('email', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('mobile', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('office_address', 'like', '%'.$request->search['value'].'%')
                        ->orWhere('created_at', 'like', '%'.$request->search['value'].'%');
                });
            })
            ->latest();

        return Datatables::of($organizations)
            ->addColumn('action', function ($organization) {
                $markup = '';
                $markup .= '<a href="'.route('admin.organization.edit', [$organization->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="#" onclick="deleteOrganization('.$organization->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->editColumn('sid', function ($organization) {
                return $organization->sid ?? 'N/A';
            })
            ->editColumn('photo', function ($organization) {
                return $organization->photo ? '<img src="'.asset($organization->photo).'" alt="Profile Image">' : 'N/A';
            })
            ->editColumn('created_at', function ($organization) {
                return $organization->created_at ?? 'N/A';
            })
            ->setFilteredRecords($organizations->count())
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

        return view('v1.admin.pages.organizations.edit', compact('userRequest', 'divisions', 'districts', 'upazillas', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return mixed
     */
    public function update(Request $request)
    {
        $request->validate([
            'type' => ['required', 'string', Rule::in([Type::Organization->value])],
            'name' => ['required', 'string'],
            'email' => ['required_without:mobile', 'email', 'nullable', new SameOrUniqueEmail($request->id)],
            'mobile' => ['required_without:email', 'string', 'nullable', new SameOrUniqueMobile($request->id)],
            'auth_file' => ['file', 'mimetypes:image/jpeg,image/png,application/pdf', 'nullable'],
            'upazila' => ['required_if:type,seeker,volunteer,organization'],
            'office_address' => ['required_if:type,organization', 'string', 'nullable'],
            'license_no' => ['string', 'nullable'],
            'license_image' => ['file', 'mimes:jpeg,png,jpg', 'nullable'],
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
            if ($userRequest->type == Type::Organization->value) {
                if (isset($request->upazila)) {
                    $userRequest->upazila_id = $request->upazila ?? null;
                }
                $userRequest->office_address = $request->office_address ?? null;
                $userRequest->license_no = $request->license_no ?? null;
                if ($request->file('license_image')) {
                    $license_image = $this->storeFile('user', $request->file('license_image'), 'license_image');
                    $userRequest->license_image = $license_image ?? null;
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

            return redirect()->back()->with('success', 'Organization Profile Updated Successfully');
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
            $organization = User::findOrFail($request->id);
            $organization->delete();
            DB::commit();

            return new JsonResponse(['message' => 'Organization Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();

            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
