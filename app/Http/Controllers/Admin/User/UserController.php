<?php

namespace App\Http\Controllers\Admin\User;

use App\Enums\User\Status;
use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
use App\Models\Rating\RatingType;
use App\Models\Rating\UserRating;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    use UserTrait;

    public function dropdown(Request $request)
    {
        $type = $request->query('type', null);

        $users = User::when($type, function ($q) use ($type) {
            $q->where('type', $type);
        })
            ->where('status', Status::Approved->value)
            ->with('upazila:id,name')
            ->select(['id', 'name', 'email', 'upazila_id'])
            ->withSum('ratings as total_score', 'score')
            ->orderByDesc('total_score')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'upazila_name' => $user->upazila?->name,
                    'total_score' => $user->total_score,
                ];
            });

        return response()->json([
            'data' => $users,
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('v1.admin.pages.users.index');
    }

    /**
     * data for datatable ajax request
     *
     * @return mixed
     */
    public function getUsersDatatableAjax(Request $request)
    {
        $users = User::with(['roles', 'ratings'])
            ->orWhere('name', 'like', '%'.$request->search['value'].'%')
            ->orWhere('email', 'like', '%'.$request->search['value'].'%')
            ->orWhereHas('roles', function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search['value'].'%');
            })->withSum('ratings as total_score', 'score')
            ->orderByDesc('total_score')->get();

        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                $markup = '<a href="'.route('admin.user.show', $user->id).'" class="btn btn-primary m-1">Show</a>';
                $markup .= '<a href="'.route('admin.user.edit', $user->id).'" class="btn btn-secondary m-1">Edit</a>';
                if (! $user->roles->pluck('name')->contains($this->super_admin_role)) {
                    $markup .= '<a href="#" onclick="deleteUser('.$user->id.')" class="btn btn-danger m-1"> Delete</a>';
                } else {
                    if (! auth()->user()->roles->pluck('name')->contains($this->super_admin_role)
                      && $user->roles->pluck('name')->contains($this->super_admin_role)) {
                        $markup = '';
                    }
                }

                return $markup;
            })
            ->editColumn('roles', function ($user) {
                $markup = '';
                foreach ($user->roles as $role) {
                    $markup .= '<span class="badge badge-info m-1">';
                    $markup .= $role->name;
                    $markup .= '</span>';
                }

                return $markup;
            })
            ->editColumn('ratings', function ($user) {
                return $user->ratings->sum('score');
            })
            ->rawColumns(['action', 'roles', 'ratings'])
            ->setFilteredRecords($users->count())
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        $roles = Role::where('name', '!=', $this->super_admin_role)->get();

        return view('v1.admin.pages.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'role_ids' => 'required|array',
        ]);
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            $roles = Role::whereIn('id', $request->role_ids)->get();
            $user->syncRoles($roles);
            DB::commit();

            return redirect()->route('admin.users.index')->with('success', 'User Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('admin.users.index')->with('error', 'Error Occurred! | '.$th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function edit($id)
    {
        $user = User::with('roles')->find($id);
        if ($user->roles->pluck('name')->contains($this->super_admin_role) && ! auth()->user()->roles->pluck('name')->contains($this->super_admin_role)) {
            return redirect()->back()->with('error', 'Super Admin Cannot be Edited');
        }
        $roles = Role::where('name', '!=', $this->super_admin_role)->get();

        return view('v1.admin.pages.users.edit', compact('user', 'roles'));
    }

    public function show(Request $request, $id)
    {
        $ratingMonth = $request->query('rating_month', null);

        $user = User::with(['roles', 'ratings' => function ($q) use ($ratingMonth) {
            $q->when($ratingMonth, function ($query) use ($ratingMonth) {
                $query->where('month_year', $ratingMonth);
            })->latest();
        }])->find($id);
        $ratingTypes = RatingType::all();

        return view('v1.admin.pages.users.show', compact('user', 'ratingTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return mixed
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|string|min:8|confirmed',
            'role_ids' => 'nullable|array',
        ]);
        DB::beginTransaction();
        try {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            if ($request->role_ids) {
                $roles = Role::whereIn('id', $request->role_ids)->get();
                $user->syncRoles($roles);
            } else {
                // $user->syncRoles([]);
            }
            DB::commit();

            return redirect()->back()->with('success', 'User Updated Successfully');
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
            $user = User::find($request->id);
            $user->delete();
            DB::commit();

            return new JsonResponse(['message' => 'User Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();

            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function ratingStore(Request $request, $id)
    {
        $this->validate($request, [
            'rating_type_id' => 'required|exists:rating_types,id',
            'score' => 'required|numeric',
            'month_year' => 'required|date_format:Y-m',
        ]);
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->ratings()->create([
                'rating_type_id' => $request->rating_type_id,
                'score' => $request->score,
                'month_year' => $request->month_year,
            ]);
            DB::commit();

            return redirect()->back()->with('success', 'Rating Added Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error Occurred! | '.$th->getMessage());
        }
    }

    public function ratingDelete($id)
    {
        DB::beginTransaction();
        try {
            $rating = UserRating::find($id);
            $rating->delete();
            DB::commit();

            return redirect()->back()->with('success', 'Rating Deleted Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error Occurred! | '.$th->getMessage());
        }
    }
}
