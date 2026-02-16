<?php

namespace App\Http\Controllers\Admin\Seeker;

use App\Enums\GlobalStatus;
use App\Enums\Seeker\SeekerApplicationFile;
use App\Enums\Seeker\SeekerApplicationStatus;
use App\Enums\User\Status;
use App\Enums\User\Type;
use App\Http\Controllers\Controller;
use App\Http\Traits\Sms;
use App\Models\Country;
use App\Models\District;
use App\Models\Division;
use App\Models\Seeker\Seeker;
use App\Models\Seeker\SeekerApplication;
use App\Models\Seeker\SeekerApplicationVolunteer;
use App\Models\Upazila;
use App\Models\User;
use App\Traits\HasFiles;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class SeekerApplicationController extends Controller
{
    use HasFiles, Sms;

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('v1.admin.pages.seeker-applications.index');
    }

    /**
     * data for datatable ajax request
     *
     * @return mixed
     */
    public function getSeekerApplicationsDatatableAjax(Request $request)
    {
        $seekerApplications = SeekerApplication::with('user')
            ->orWhereHas('user', function ($query) use ($request) {
                $query->when($request->search['value'] != null, function ($q) use ($request) {
                    $q->where('name', 'like', '%'.$request->search['value'].'%');
                });
            })
            ->orWhereHas('volunteers', function ($query) use ($request) {
                $query->when($request->search['value'] != null, function ($q) use ($request) {
                    $q->where('name', 'like', '%'.$request->search['value'].'%');
                });
            })
            ->when($request->search['value'] != null, function ($q) use ($request) {
                $q->orWhere('sid', 'like', '%'.$request->search['value'].'%')
                    ->orWhere('title', 'like', '%'.$request->search['value'].'%')
                    ->orWhere('requested_amount', 'like', '%'.$request->search['value'].'%')
                    ->orWhere('completion_date', 'like', '%'.$request->search['value'].'%')
                    ->orWhere('status', 'like', '%'.$request->search['value'].'%')
                    ->orWhere('created_at', 'like', '%'.$request->search['value'].'%');
            })
            ->latest();

        return Datatables::of($seekerApplications)
            ->addColumn('action', function ($seekerApplication) {
                $markup = '';
                $markup .= '<a href="'.route('admin.seeker-application.edit', [$seekerApplication->id]).'" class="btn btn-secondary m-1">Edit</a>';
                $markup .= '<a href="'.route('admin.seeker-application.show', [$seekerApplication->id]).'" class="btn btn-primary m-1">Show</a>';
                $markup .= '<a href="#" onclick="deleteSeekerApplication('.$seekerApplication->id.')" class="btn btn-danger m-1"> Delete</a>';

                return $markup;
            })
            ->editColumn('sid', function ($seekerApplication) {
                return $seekerApplication->sid ?? 'N/A';
            })
            ->editColumn('assigned_volunteer', function ($seekerApplication) {
                return $seekerApplication->volunteers[0]->name ?? 'N/A';
            })
            ->editColumn('created_at', function ($seekerApplication) {
                return $seekerApplication->created_at ?? 'N/A';
            })
            ->editColumn('status', function ($seekerApplication) {
                $markup = '';
                if ($seekerApplication->status == SeekerApplicationStatus::PENDING->value) {
                    $markup = '<span class="badge badge-warning m-1">pending</span>';
                } elseif ($seekerApplication->status == SeekerApplicationStatus::APPROVED->value) {
                    $markup = '<span class="badge badge-success m-1">approved</span>';
                } elseif ($seekerApplication->status == SeekerApplicationStatus::INVESTIGATING->value) {
                    $markup = '<span class="badge badge-info m-1">investigating</span>';
                } elseif ($seekerApplication->status == SeekerApplicationStatus::REJECTED->value) {
                    $markup = '<span class="badge badge-danger m-1">rejected</span>';
                }

                return $markup;
            })
            ->rawColumns(['action', 'status', 'sid'])
            ->setFilteredRecords($seekerApplications->count())
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        $seekers = User::where('type', Type::Seeker->value)
            ->where('status', Status::Approved->value)
            ->get();

        return view('v1.admin.pages.seeker-applications.create', compact('seekers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'seeker_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'requested_amount' => ['required', 'numeric'],
            'completion_date' => ['nullable', 'date'],
            'created_for_self' => ['required', 'boolean'],
            'document' => ['file', 'mimetypes:image/jpeg,image/png,application/pdf', 'nullable'],
            'image' => ['file', 'mimes:jpeg,png,jpg', 'nullable'],
            'status' => ['required', 'in:'.implode(',', SeekerApplicationStatus::values())],
        ]);

        // return $request;
        DB::beginTransaction();
        try {
            $seekerApplication = new SeekerApplication();
            $seekerApplication->user_id = $request->seeker_id;
            $seekerApplication->title = $request->title;
            $seekerApplication->title_bn = $request->title_bn;
            $seekerApplication->title_ar = $request->title_ar;
            $seekerApplication->description = $request->description ?? null;
            $seekerApplication->description_bn = $request->description_bn ?? null;
            $seekerApplication->description_ar = $request->description_ar ?? null;
            $seekerApplication->requested_amount = $request->requested_amount;
            $seekerApplication->completion_date = $request->completion_date ?? null;
            // $seekerApplication->created_for_self = $request->created_for_self;
            $seekerApplication->status = $request->status ?? SeekerApplicationStatus::PENDING->value;
            if ($request->file('document')) {
                $documentPath = $this->storeFile('user', $request->file('document'), 'document');
                $seekerApplication->document = $documentPath ?? null;
            }
            if ($request->file('image')) {
                $photoPath = $this->storeFile('user', $request->file('image'), 'image');
                $seekerApplication->image = $photoPath ?? null;
            }
            $seekerApplication->save();

            // if ($request->hasFile('auth_file')) {
            //     $seekerApplication->addMedia($request->file('auth_file'))->toMediaCollection(SeekerApplicationFile::AUTH_FILE->value);
            // }
            DB::commit();

            return redirect()->back()->with('success', 'Seeker Application Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error Occurred! | '.$th->getMessage());
        }

    }

    public function show($id)
    {
        $seekerApplication = SeekerApplication::with(['user', 'volunteers'])->find($id);

        // return $seekerApplication->volunteers;
        return view('v1.admin.pages.seeker-applications.show', compact('seekerApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function edit($id)
    {
        $seekerApplication = SeekerApplication::with(['user', 'volunteers'])->find($id);

        // Check in the upazila
        $volunteers = User::where('type', Type::Volunteer->value)
            ->where('status', Status::Approved->value)
            ->where('upazila_id', $seekerApplication->user->upazilla)
            ->withSum('ratings as total_score', 'score')
            ->orderByDesc('total_score')
            ->get();

        // Check in the district
        if ($volunteers->isEmpty()) {
            $allUpazilas = $seekerApplication->user->upazila->district->upazilas()->pluck('id');
            // return $allUpazilas;
            $volunteers = User::where('type', Type::Volunteer->value)
                ->where('status', Status::Approved->value)
                ->whereIn('upazila_id', $allUpazilas)
                ->withSum('ratings as total_score', 'score')
                ->orderByDesc('total_score')
                ->get();
            // return $volunteers;
        }
        // Check in the division
        if ($volunteers->isEmpty()) {
            $allDistricts = $seekerApplication->user->upazila->district->division->districts()->pluck('id');
            $allUpazilas = Upazila::whereIn('district_id', $allDistricts)->pluck('id');
            // return $allUpazilas;
            $volunteers = User::where('type', Type::Volunteer->value)
                ->where('status', Status::Approved->value)
                ->whereIn('upazila_id', $allUpazilas)
                ->withSum('ratings as total_score', 'score')
                ->orderByDesc('total_score')
                ->get();
            // return $volunteers;
        }

        // Check in the country
        if ($volunteers->isEmpty()) {
            $volunteers = User::where('type', Type::Volunteer->value)
                ->where('status', Status::Approved->value)
                ->withSum('ratings as total_score', 'score')
                ->orderByDesc('total_score')
                ->get();
            // return $volunteers;
        }

        // return $volunteers;

        // return $seekerApplication;
        // return $seekerApplication->volunteers[0]->id;

        // $divisions = Division::all();
        // $districts = District::all();
        // $upazilas = Upazila::all();
        // $countries = Country::all();

        // return view('v1.admin.pages.seeker-applications.edit', compact('seekerApplication', 'volunteers', 'countries', 'upazilas', 'divisions', 'districts'));
        return view('v1.admin.pages.seeker-applications.edit', compact('seekerApplication', 'volunteers'));
    }

    public function updateStatus($status, $id)
    {
        $seekerApplication = SeekerApplication::find($id);
        $seekerApplication->status = $status;
        $seekerApplication->save();

        return redirect()->to('/admin/seeker-application')->with('success', 'Seeker Application Status Updated Successfully');
    }

    public function updateVolunteerDocumentStatus(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:seeker_applications,id'],
            'status' => ['required', Rule::enum(GlobalStatus::class)],
        ]);

        try {
            $seekerApplication = SeekerApplication::find($request->id);
            $seekerApplication->volunteer_document_status = $request->status;
            if ($request->status == GlobalStatus::Declined->value) {
                $this->removeFile($seekerApplication->volunteer_document);
                $seekerApplication->volunteer_document = null;
            }
            $seekerApplication->save();

            return response()->json(['message' => "Seeker Application volunteer document {$request->status} Successfully"], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Error Occurred! | {$th->getMessage()}"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
            'volunteer_id' => ['nullable', 'exists:users,id'],
            // 'created_for_self' => ['required', 'boolean'],
            // 'auth_file' => ['nullable', 'file', 'required_if:created_for_self,false', 'mimes:pdf'],
            'status' => ['required', 'in:'.implode(',', SeekerApplicationStatus::values())],
            'image' => ['file', 'mimes:jpeg,png,jpg', 'nullable'],
            'document' => ['file', 'mimetypes:image/jpeg,image/png,application/pdf', 'nullable'],
            'comment' => ['nullable'],
        ]);
        DB::beginTransaction();
        try {
            $seekerApplication = SeekerApplication::find($request->id);
            $seekerApplication->title = $request->title;
            $seekerApplication->title_bn = $request->title_bn;
            $seekerApplication->title_ar = $request->title_ar;
            $seekerApplication->description = $request->description ?? null;
            $seekerApplication->description_bn = $request->description_bn ?? null;
            $seekerApplication->description_ar = $request->description_ar ?? null;
            $seekerApplication->requested_amount = $request->requested_amount;
            $seekerApplication->completion_date = $request->completion_date ?? null;
            $seekerApplication->comment = $request->comment ?? null;
            // $seekerApplication->created_for_self = $request->created_for_self;
            $seekerApplication->status = $request->status;
            if ($request->file('document')) {
                $documentPath = $this->storeFile('user', $request->file('document'), 'document');
                $seekerApplication->document = $documentPath ?? null;
            }
            if ($request->file('image')) {
                $photoPath = $this->storeFile('user', $request->file('image'), 'image');
                $seekerApplication->image = $photoPath ?? null;
            }
            $seekerApplication->save();

            $seekerApplicationVolunteers = $seekerApplication->volunteers;

            if ($request->volunteer_id && (count($seekerApplicationVolunteers) == 0 || $seekerApplication->volunteers()->first()->id != $request->volunteer_id)) {

                if (count($seekerApplicationVolunteers) > 0) {
                    $seekerApplication->volunteers()->delete();
                }
                $assignVolunteer = new SeekerApplicationVolunteer();
                $assignVolunteer->seeker_application_id = $seekerApplication->id;
                $assignVolunteer->user_id = $request->volunteer_id;
                $assignVolunteer->save();

                $volunteer = User::findOrFail($request->volunteer_id);

                $volunteerMobile = $assignVolunteer->user->mobile;
                if ($volunteerMobile) {
                    $message = <<<EOD
                    You have been assigned the seeker application(ID: {$seekerApplication->sid})."
                    
                    Thank you,
                    The HelpNHelpers Support Team
                    EOD;
                    $deliveryStatus = $this->smsSend($volunteerMobile, $message);

                    $message = <<<EOD
                    Volunteer(ID: {$volunteer->sid}) has been assigned to the seeker application(ID: {$seekerApplication->sid})

                    Thank you,
                    HelpNHelpers Support Team
                    EOD;
                    $deliveryStatus = $this->smsSend($seekerApplication->user->mobile, $message);
                }
            }

            DB::commit();

            return redirect()->to('/admin/seeker-application')->with('success', 'Seeker Application Updated Successfully');

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
            $seekerApplication = SeekerApplication::find($request->id);
            $seekerApplication->delete();
            DB::commit();

            return new JsonResponse(['message' => 'Seeker Application Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();

            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUpazilaSelectedVolunteers($upazila_id)
    {
        try {
            $volunteers = User::where('upazila_id', $upazila_id)->get();

            return response()->json(['data' => $volunteers], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
