<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\Role;
use App\PermissionRole;
use DB;

class PermissionController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:permission-list', ['only' => ['show', 'index']]);
        $this->middleware('permission:permission-create', ['only' => ['create']]);
        $this->middleware('permission:permission-update', ['only' => ['edit']]);
        $this->middleware('permission:permission-delete', ['only' => ['delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $query = Permission::sortable(['id' => 'ASC']);
        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $search = $request->search_keyword;
            $query->where('name', 'LIKE', '%' . $search . '%');
            $query->orWhere('display_name', 'LIKE', '%' . $search . '%');
            $query->orWhere('description', 'LIKE', '%' . $search . '%');
            
        }
        $permissions = $query->paginate(10);
        return view('permissions.index', compact('permissions'))
                        ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $roles = Role::pluck('display_name', 'id');
        return view('permissions.create', compact('roles')); //return the view with the list of roles passed as an array
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
            'display_name' => 'required',
            'description' => 'required',
        ]);
        //create the new permission
        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->save();
        //attach to the selected roles
        if ($request->input('roles') != null) {
            foreach ($request->input('roles') as $key => $value) {
                PermissionRole::attachToRole($permission->id, $value);
            }
        }
        return redirect()->route('admin.permissions.index')
                        ->with('success', 'Permission created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $permission = Permission::find($id); //Find the requested permission
        //return the view with the permission info
        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $permission = Permission::find($id); //Find the requested permission
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'display_name' => 'required',
            'description' => 'required'
        ]);
        //Find the permission and update its details
        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->save();

        return redirect()->route('admin.permissions.index')
                        ->with('success', 'permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        DB::table("permissions")->where('id', $id)->delete();
        return redirect()->route('admin.permissions.index')
                        ->with('success', 'permission deleted successfully');
    }

    public function checkUnique(Request $request) {
        if ($request->ajax() && (!empty($request->name) || !empty($request->display_name))) {
            $id = null;
            if (isset($request->id) && !empty($request->id)) {
                $id = $request->id;
            }
            if (!empty($request->display_name)) {
                $field = 'display_name';
            } else {
                $field = 'name';
            }
            $flag = checkUnique('permissions', $field, $request->$field, $id);
            return response()->json($flag);
        }
    }

}
