<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    use UserTrait;

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('v1.admin.pages.roles.index');
    }

    /**
     * data for datatable ajax request
     *
     * @return mixed
     */
    public function getRolesDatatableAjax(Request $request)
    {
        $roles = Role::orWhere('name', 'like', '%'.$request->search['value'].'%')
            ->orWhere('guard_name', 'like', '%'.$request->search['value'].'%')
            ->orderBy('created_at', 'ASC')
            ->latest();

        return Datatables::of($roles)
            ->addColumn('action', function ($role) {
                $markup = '';
                if ($role->name != $this->super_admin_role) {
                    $markup = '<a href="'.route('admin.role.edit', $role->id).'" class="btn btn-secondary m-1">Edit</a>';
                    $markup .= '<a href="#" onclick="deleteRole('.$role->id.')" class="btn btn-danger m-1"> Delete</a>';
                }

                return $markup;
            })
            ->rawColumns(['action'])
            ->setFilteredRecords($roles->count())
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('v1.admin.pages.roles.create', compact('permissions'));
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
            'permission_ids' => 'required|array',
        ]);
        DB::beginTransaction();
        try {
            $role = new Role();
            $role->name = strtolower($request->name);
            $role->save();
            $permissions = Permission::whereIn('id', $request->permission_ids)->get();
            $role->syncPermissions($permissions);
            DB::commit();

            return redirect()->route('admin.roles.index')->with('success', 'Role Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('admin.roles.index')->with('error', 'Error Occurred! | '.$th->getMessage());
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
        $role = Role::with('permissions')->find($id);
        if ($role->name == $this->super_admin_role) {
            return redirect()->back()->with('error', 'Super Admin Cannot be Edited');
        }
        $permissions = Permission::all();

        return view('v1.admin.pages.roles.edit', compact('role', 'permissions'));
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
            'permission_ids' => 'required|array',
        ]);
        DB::beginTransaction();
        try {
            $role = Role::find($request->id);
            $role->name = strtolower($request->name);
            $role->save();
            $permissions = Permission::whereIn('id', $request->permission_ids)->get();
            $role->syncPermissions($permissions);
            DB::commit();

            return redirect()->back()->with('success', 'Role Updated Successfully');
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
            $role = Role::find($request->id);
            $role->delete();
            DB::commit();

            return new JsonResponse(['message' => 'Role Deleted Successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();

            return new JsonResponse('Error Occurred! | '.$th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
