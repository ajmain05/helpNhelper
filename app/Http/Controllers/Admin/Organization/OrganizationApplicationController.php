<?php

namespace App\Http\Controllers\Admin\Organization;

use App\Enums\Organization\OrganizationApplicationFile;
use App\Enums\Organization\OrganizationApplicationStatus;
use App\Enums\User\Status;
use App\Enums\User\Type;
use App\Http\Controllers\Controller;
use App\Http\Traits\Sms;
use App\Models\Country;
use App\Models\District;
use App\Models\Division;
use App\Models\Organization\OrganizationApplication;
use App\Models\Organization\OrganizationApplicationVolunteer;
use App\Models\Upazila;
use App\Models\User;
use App\Traits\HasFiles;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OrganizationApplicationController extends Controller
{
    use HasFiles, Sms;

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('v1.admin.pages.organization-applications.index');
    }

    /**
     * data for datatable ajax request
     *
     * @return mixed
     */
    public function getOrganizationApplicationsDatatableAjax(Request $request)
    {
        $searchValue = $request->search['value'] ?? null;

        $organizationApplications = OrganizationApplication::with(['organization', 'assignedVolunteer'])
            ->when($searchValue, function ($q) use ($searchValue) {
                $q->where(function ($inner) use ($searchValue) {
                    $inner->where('sid', 'like', "%{$searchValue}%")
                        ->orWhere('title', 'like', "%{$searchValue}%")
                        ->orWhere('requested_amount', 'like', "%{$searchValue}%")
                        ->orWhere('collected_amount', 'like', "%{$searchValue}%")
                        ->orWhere('status', 'like', "%{$searchValue}%")
                        ->orWhere('created_at', 'like', "%{$searchValue}%")
                        ->orWhereHas('organization', function ($uq) use ($searchValue) {
                            $uq->where('name', 'like', "%{$searchValue}%");
                        })
                        ->orWhereHas('assignedVolunteer', function ($vq) use ($searchValue) {
                            $vq->where('name', 'like', "%{$searchValue}%");
                        });
                });
            })
            ->latest();

        return Datatables::of($organizationApplications)
            ->addColumn('action', function ($organizationApplication) {
                $markup = '';
                $markup .= '<a href="'.route('admin.organization-application.edit', [$organizationApplication->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="'.route('admin.organization-application.show', [$organizationApplication->id]).'" class="btn btn-primary m-1">Show</a>';
                $markup .= '<a href="#" onclick="deleteOrganizationApplication('.$organizationApplication->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->editColumn('sid', function ($organizationApplication) {
                return $organizationApplication->sid ?? 'N/A';
            })
            ->editColumn('assigned_volunteer', function ($organizationApplication) {
                return $organizationApplication->assignedVolunteer->name ?? 'N/A';
            })
            ->editColumn('status', function ($organizationApplication) {
                $markup = '';
                if ($organizationApplication->status == OrganizationApplicationStatus::PENDING->value) {
                    $markup = '<span class="badge badge-warning m-1">pending</span>';
                } elseif ($organizationApplication->status == OrganizationApplicationStatus::APPROVED->value) {
                    $markup = '<span class="badge badge-success m-1">approved</span>';
                } elseif ($organizationApplication->status == OrganizationApplicationStatus::INVESTIGATING->value) {
                    $markup = '<span class="badge badge-info m-1">investigating</span>';
                } elseif ($organizationApplication->status == OrganizationApplicationStatus::REJECTED->value) {
                    $markup = '<span class="badge badge-danger m-1">rejected</span>';
                }

                return $markup;
            })
            ->editColumn('created_at', function ($organizationApplication) {
                return $organizationApplication->created_at ?? 'N/A';
            })
            ->rawColumns(['action', 'status', 'sid', 'created_at'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        $organizations = User::where('type', Type::Organization->value)->get();

        // return $organizations;

        return view('v1.admin.pages.organization-applications.create', compact('organizations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'organization_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'requested_amount' => ['required', 'numeric'],
            'completion_date' => ['nullable', 'date'],
            'created_for_self' => ['required', 'boolean'],
            'auth_file' => ['nullable', 'file', 'required_if:created_for_self,false', 'mimes:pdf'],
            'status' => ['required', 'in:'.implode(',', OrganizationApplicationStatus::values())],
        ]);
        DB::beginTransaction();
        try {
            $organizationApplication = new OrganizationApplication();
            $organizationApplication->user_id = $request->organization_id;
            $organizationApplication->title = $request->title;
            $organizationApplication->description = $request->description ?? null;
            $organizationApplication->requested_amount = $request->requested_amount;
            $organizationApplication->completion_date = $request->completion_date ?? null;
            $organizationApplication->status = $request->status ?? OrganizationApplicationStatus::PENDING->value;
            $organizationApplication->save();
            if ($request->hasFile('auth_file')) {
                $organizationApplication->addMedia($request->file('auth_file'))->toMediaCollection(OrganizationApplicationFile::AUTH_FILE->value);
            }
            DB::commit();

            return redirect()->back()->with('success', 'Organization Application Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error Occurred! | '.$th->getMessage());
        }

    }

    public function show($id)
    {
        $organizationApplication = OrganizationApplication::with(['user', 'volunteers'])->find($id);

        // return $organizationApplication;
        return view('v1.admin.pages.organization-applications.show', compact('organizationApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function edit($id)
    {
        $organizationApplication = OrganizationApplication::with(['user'])->find($id);
        // Check in the upazila
        $volunteers = User::where('type', Type::Volunteer->value)
            ->where('status', Status::Approved->value)
            ->when($organizationApplication->user && $organizationApplication->user->upazila_id, function($q) use ($organizationApplication) {
                $q->where('upazila_id', $organizationApplication->user->upazila_id);
            })
            ->get();

        // Check in the district
        if ($volunteers->isEmpty() && $organizationApplication->user && $organizationApplication->user->upazila && $organizationApplication->user->upazila->district) {
            $allUpazilas = $organizationApplication->user->upazila->district->upazilas()->pluck('id');
            $volunteers = User::where('type', Type::Volunteer->value)
                ->where('status', Status::Approved->value)
                ->whereIn('upazila_id', $allUpazilas)
                ->get();
        }
        // Check in the division
        if ($volunteers->isEmpty() && $organizationApplication->user && $organizationApplication->user->upazila && $organizationApplication->user->upazila->district && $organizationApplication->user->upazila->district->division) {
            $allDistricts = $organizationApplication->user->upazila->district->division->districts()->pluck('id');
            $allUpazilas = Upazila::whereIn('district_id', $allDistricts)->pluck('id');
            $volunteers = User::where('type', Type::Volunteer->value)
                ->where('status', Status::Approved->value)
                ->whereIn('upazila_id', $allUpazilas)
                ->get();
        }

        // Check in the country
        if ($volunteers->isEmpty()) {
            $volunteers = User::where('type', Type::Volunteer->value)
                ->where('status', Status::Approved->value)
                ->get();
        }

        return view('v1.admin.pages.organization-applications.edit', compact('organizationApplication', 'volunteers'));
    }

    public function updateStatus($status, $id)
    {
        $organizationApplication = OrganizationApplication::find($id);
        $organizationApplication->status = $status;
        $organizationApplication->save();

        return redirect()->to('/admin/organization-application')->with('success', 'Organization Application Status Updated Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return mixed
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required'],
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'requested_amount' => ['required', 'numeric'],
            'completion_date' => ['nullable', 'date'],
            // 'created_for_self' => ['required', 'boolean'],
            // 'auth_file' => ['nullable', 'file', 'required_if:created_for_self,false', 'mimes:pdf'],
            'category' => ['nullable', 'string'],
            'seeker_name' => ['nullable', 'string'],
            'seeker_location' => ['nullable', 'string'],
            'payment_method' => ['nullable', 'string'],
            'payment_account' => ['nullable', 'string'],
            'status' => ['required', 'in:'.implode(',', OrganizationApplicationStatus::values())],
            'collected_amount' => ['nullable', 'numeric'],
            'service_charge_pct' => ['nullable', 'numeric'],
            'image' => ['file', 'mimes:jpeg,png,jpg', 'nullable'],
            'document' => ['file', 'mimetypes:image/jpeg,image/png,application/pdf', 'nullable'],
        ]);
        DB::beginTransaction();
        try {
            $organizationApplication = OrganizationApplication::find($request->id);
            $organizationApplication->title = $request->title;
            $organizationApplication->description = $request->description ?? null;
            $organizationApplication->category = $request->category ?? null;
            $organizationApplication->requested_amount = $request->requested_amount;
            $organizationApplication->collected_amount = $request->collected_amount ?? 0;
            $organizationApplication->seeker_name = $request->seeker_name ?? null;
            $organizationApplication->seeker_location = $request->seeker_location ?? null;
            $organizationApplication->payment_method = $request->payment_method ?? null;
            $organizationApplication->payment_account = $request->payment_account ?? null;
            $organizationApplication->completion_date = $request->completion_date ?? null;
            $organizationApplication->service_charge_pct = $request->service_charge_pct ?? 7.00;
            // $organizationApplication->created_for_self = $request->created_for_self;
            $organizationApplication->status = $request->status;
            if ($request->file('document')) {
                $documentPath = $this->storeFile('user', $request->file('document'), 'document');
                $organizationApplication->document = $documentPath ?? null;
            }
            if ($request->file('image')) {
                $photoPath = $this->storeFile('user', $request->file('image'), 'image');
                $organizationApplication->image = $photoPath ?? null;
            }
            $organizationApplication->save();

            if ($request->volunteer_id && $organizationApplication->assigned_volunteer_id != $request->volunteer_id) {
                $organizationApplication->assigned_volunteer_id = $request->volunteer_id;
                $organizationApplication->save();

                $volunteer = User::find($request->volunteer_id);
                $volunteerMobile = $volunteer ? $volunteer->mobile : null;
                if ($volunteerMobile) {
                    $message = <<<EOD
                    "You have been assigned the organization application titled: {$organizationApplication->title}."
                    Thank you,
                    HelpNHelpers Support Team
                    EOD;
                    $deliveryStatus = $this->smsSend($volunteerMobile, $message);
                }
            }

            DB::commit();

            return redirect()->to('/admin/organization-application')->with('success', 'Organization Application Updated Successfully');

        } catch (UniqueConstraintViolationException) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Provided volunteer already exists');
        } catch (\Throwable $th) {
            DB::rollBack();

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
            $organizationApplication = OrganizationApplication::find($request->id);
            $organizationApplication->delete();
            DB::commit();

            return new JsonResponse(['message' => 'Organization Application Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();

            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
