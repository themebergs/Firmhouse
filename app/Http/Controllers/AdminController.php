<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Response;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Admin');
    }

    public function index()
    {
        $title = 'Admin';
        $AllAdmin = User::where('id','<>',auth()->id())->whereIn('admin_role', ['admin', 'super_admin'])->orderBy('id', 'DESC')->paginate(25);
        return view('admin.pages.user.index')-> with(compact('title', 'AllAdmin'));  
    }

    public function investors(){
        $title = 'Investors';
        $AllAdmin = User::where('active', 1)->where('investor', 1)->orderBy('id', 'DESC')->paginate(25);
        return view('admin.pages.user.index')-> with(compact('title', 'AllAdmin'));  
    }

    public function edit($id)
    {
        $User = User::find($id);
        return view('admin.pages.profile.profile_index')->with(compact('User'));  
    }

    public function update(Request $request)
    {
        $id = $request['id'];
        $update = User::findOrFail($id);
        $update->admin_role = $request['admin_role'];
        $update->role_id = $request['role_id'];
        $update->save();  
        return back()->with('success', 'User Role Updated');

    }

    public function destroy($id)
    {
        $delete = User::findOrFail($id);
        $delete->active = 0;
        $delete->save();  
        return back()->with('success', 'Admin Deleted');
    }
}
