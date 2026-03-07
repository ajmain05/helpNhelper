<?php

namespace App\Http\Controllers\Api;

use App\Enums\GlobalStatus;
use App\Enums\User\Type;
use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Seeker\SeekerApplication;
use App\Models\Seeker\SeekerApplicationVolunteer;
use App\Traits\HasFiles;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use HasFiles;

    public function fundRequestStore(Request $request)
    {
        if (Auth::user() && Auth::user()->type == Type::Seeker->value) {
            $request->validate([
                'title' => ['required'],
                'description' => ['required'],
                'requested_amount' => ['required', 'numeric'],
                'completion_date' => ['required', 'date', 'after:today'],
                'terms' => ['required'],
            ]);
            try {
                DB::beginTransaction();

                $seekerApplication = new SeekerApplication();
                $seekerApplication->user_id = Auth::user()->id;
                $seekerApplication->title = $request->title;
                $seekerApplication->description = $request->description ?? null;
                $seekerApplication->requested_amount = $request->requested_amount;
                $seekerApplication->completion_date = $request->completion_date;
                $seekerApplication->save();

                DB::commit();

                return response()->json([
                    'message' => 'Seeker Application Created Successfully',
                ], Response::HTTP_OK);

            } catch (\Throwable $th) {

                DB::rollBack();

                return new JsonResponse(
                    [
                        'message' => $th->getMessage(),
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        } else {
            return response()->json([
                'message' => 'Please login as a seeker to apply your application.',
            ], Response::HTTP_FORBIDDEN);
        }

    }

    public function index()
    {
        $user = Auth::user()->load(['upazila.district.division.country']);

        return response()->json([
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'auth_file' => asset($user->auth_file),
                'photo' => asset($user->photo),
                'type' => $user->type,
                'status' => $user->status,
                'address' => [
                    'upazila' => $user->upazila->name,
                    'district' => $user->upazila->district->name,
                    'division' => $user->upazila->district->division->name,
                    'country' => $user->upazila->district->division->country->name,
                ],
                'permanent_address' => $user->permanent_address,
                'present_address' => $user->present_address,
            ],
        ], Response::HTTP_OK);
    }

    public function history()
    {
        $history = new Collection();
        if (Auth::user()?->type == Type::Seeker->value) {
            $history = SeekerApplication::with('user')
                ->where('user_id', Auth::user()->id)->latest()->get();
        } elseif (Auth::user()?->type == Type::Volunteer->value) {
            $history = SeekerApplicationVolunteer::with(['application', 'user'])
                ->where('user_id', Auth::user()->id)
                ->latest()->get();
        } elseif (Auth::user()?->type == Type::Donor->value) {
            $history = Donation::with(['user'])
                ->where('user_id', Auth::user()->id)
                ->latest()->get();
        }

        return response()->json([
            'data' => $history,
        ], Response::HTTP_OK);
    }

    public function investigateDocument(Request $request, $id)
    {
        $request->validate([
            'volunteer_document' => 'required',
            'comment' => 'nullable',
        ]);
        try {
            $application = SeekerApplication::findOrFail($id);

            $filePath = $this->storeFile('seeker-application', $request->file('volunteer_document'), 'Seeker-Application');
            $application->volunteer_document = $filePath;
            $application->volunteer_document_status = GlobalStatus::Pending->value;
            $application->comment = $request->comment ?? null;
            $application->save();

            return response()->json([
                'message' => 'Investigating Document submitted successfully.',
            ], Response::HTTP_OK);

        } catch (ModelNotFoundException) {

            DB::rollBack();

            return new JsonResponse(
                [
                    'message' => 'Data not found',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (\Throwable $th) {

            DB::rollBack();

            return new JsonResponse(
                [
                    'message' => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update the authenticated user's profile (name, mobile, photo).
     * Called via POST /api/v1/update-profile (multipart/form-data).
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $request->validate([
            'name'   => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'photo'  => ['nullable', 'image', 'max:4096'],
        ]);

        try {
            $user = Auth::user();

            if ($request->filled('name')) {
                $user->name = $request->name;
            }

            if ($request->filled('mobile')) {
                $user->mobile = $request->mobile;
            }

            if ($request->hasFile('photo')) {
                $filePath = $this->storeFile('profiles', $request->file('photo'), 'Profile');
                $user->photo = $filePath;
            }

            $user->save();

            return response()->json([
                'message' => 'Profile updated successfully.',
                'user'    => [
                    'id'     => $user->id,
                    'name'   => $user->name,
                    'email'  => $user->email,
                    'mobile' => $user->mobile,
                    'photo'  => $user->photo ? asset($user->photo) : null,
                    'type'   => $user->type,
                    'status' => $user->status,
                ],
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return new JsonResponse(
                ['message' => $th->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
