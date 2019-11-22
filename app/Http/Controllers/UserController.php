<?php

namespace App\Http\Controllers;

use File;
use Gate;
use App\User;
use App\role;
use App\salary;
use Response;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = auth()->user()->id;
        $User = User::find($id);
        return view('admin.pages.profile.profile_index')->with(compact('User'));  
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes | required | string | max:255',
            'username' => 'sometimes | required | string | max:255',
            'admin_role' => 'sometimes | nullable | string | max:255',
            'employee_role' => 'sometimes | nullable | max:255',
            'email' => 'sometimes | nullable | string | email | max:255 | unique:users',
            'password' => 'sometimes | required | string | min:8 | confirmed'
        ]);
        
        if ($validator->fails()){

            return response()->json(['errors'=>$validator->errors()->all()]);

        }else{

            $store = new User;
            $store->name = $request->input('name');
            $store->username = $request->input('username');
            $store->email = $request->input('email');

            if(isset($request['admin_role'])){
                $store->admin_role = decrypt($request->input('admin_role'));
                $title = 'Admin';
            }

            if(isset($request['employee_role'])){
                $store->role_id = decrypt($request->input('employee_role'));
                $role_id = decrypt($request->input('employee_role'));
                $role = role::findOrFail($role_id);
                $title = $role->name;
            }

            if(isset($request['investor'])){
                $store->investor = 1;
                $title = 'Admin';
            }

            $store->password = Hash::make($request->input('password'));
    
            $store->save();
            
            if(isset($request['employee_role'])){
                $store_salary = new salary;
                $store_salary->user_id = $store->id;
                $store_salary->amount = $request->salary;
                $store_salary->save();
            }

            $response = array(
                'ajax_status' => 'success',
                'ajax_message' => 'New '.$title.' Registered',
                'id' => $store->id,
                'name' => $store->name,
                'username' => $store->username,
                'email' => $store->email,
                'admin_role' => $store->admin_role,
                'employee_role' => $store->employee_role,
                'created_at' => $store->created_at->format('d/m/Y'),
            );
    
            return Response::json( $response );

        }

    }


    public function update(UserRequest $request, $id)
    {
        $update = User::findOrFail($id);

        if ($request->hasFile('user_image')) {

            if(isset($update->user_image) || !empty($update->user_image)){
                if (File::exists(public_path('/images/user/'.$update->user_image))) {
                    unlink(public_path('/images/user/'.$update->user_image));
                }
            }
            
            $image_name = time().'.'.$request->user_image->getClientOriginalExtension();
            $path= $request->file('user_image')->move(public_path('/images/user'), $image_name);
            $update->user_image = $image_name;

        }else{
            $this->validate($request,[
                'email' => 'sometimes|required|email|unique:users,email,'.$update->id,
                'username' => 'sometimes|nullable|unique:users,username,'.$update->id,
                ]);
            
            if(isset($request['salary'])){
                $update_salary = salary::findOrFail($update->Salary->id);
                $update_salary->user_id = $id;
                $update_salary->amount = $request['salary'];
                $update_salary->save();
            }

            $update->name = $request['name'];
            $update->username = $request['username'];
            $update->email = $request['email'];
            $update->nid = $request['nid'];
            $update->phone = $request['phone'];
            $update->address = $request['address'];
        }
        
        $update->save();             
        return back()->with('success', 'Information Updated');
        
    }


}

