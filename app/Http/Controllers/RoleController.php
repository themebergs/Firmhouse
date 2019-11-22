<?php

namespace App\Http\Controllers;

use App\role;
use App\User;
use Response;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Admin');
    }

    public function index()
    {
        $roles = role::orderBy('id', 'DESC')->get();
        return view('admin.pages.roles.index')->with(compact('roles'));  
    }

    public function store(RoleRequest $request)
    {
        $store = new role;
        $store->name = $request['name'];
        $store->description = $request['description'];
        $store->save();
        return back()->with('success', 'Role Created');
    }

    public function edit($id)
    {
        $Role = role::find($id);
        $roles = role::orderBy('id', 'DESC')->get();
        return view('admin.pages.roles.index')->with(compact('Role', 'roles'));
    }

    public function Update(Request $request, $id)
    {
        $update = role::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|unique:roles,name,'.$update->id,
            ]);

        $update->name = $request['name'];
        $update->description = $request['description'];

        $update->save();             
        return back()->with('success', 'Role Updated');
    }

    public function destroy($id)
    {
        $delete = role::find($id); 
        $delete->delete();
        return back()->with('success', 'Role Deleted');
    }

    Public function show($id)
    {
        $roles = role::get();
        $role = role::find($id);
        $title = $role->name;
        $AllAdmin = User::where('role_id', $id)->where('active', 1)->orderBy('id', 'DESC')->paginate(25);
        return view('admin.pages.user.index')-> with(compact('roles', 'title', 'AllAdmin'));  
    }
}
