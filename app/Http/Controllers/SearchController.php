<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Admin');
    }

    public function search(Request $request)
    {
        if($request->ajax()) { 
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = User::where('name', 'like', '%'.$query.'%')
                            ->orWhere('email', 'like', '%'.$query.'%')
                            ->orWhere('phone', 'like', '%'.$query.'%')
                            ->orWhere('username', 'like', '%'.$query.'%')
                            ->orWhere('id', 'like', '%'.$query.'%')
                            ->orderBy('id', 'desc')
                            ->paginate(15);
            }else {
                $data = '';
            }
            $total_row = $data->count();

            if($total_row > 0) {
                foreach($data as $row) {
                    if($row->user_image != '' || $row->user_image != NULL){
                        $image = '<img src="'.asset("images/user/".$row->user_image).'" alt="'.$row->name.'" style="max-width:25px;max-height:30px;width:auto;height:auto;">';
                    }else{
                        $image = '';
                    }

                    $investor = '';
                    $role = '';
                    $admin_role = '';
                    if($row->admin_role == 'super_admin'){
                        $admin_role = 'Super Admin';
                    }
                    elseif($row->admin_role == 'admin'){
                        $admin_role = 'Admin';
                    }
                    else{
                        $admin_role = 'User';
                    }
                    if($row->role_id != ''){
                        $role = $row->Role->name;
                    }
                    if ($row->investor == '1'){
                        $investor =  'Investor';
                    }
                    
                    $output .= '
                        <tr>
                            <td class="image">
                                '.$image.'
                            </td>
                            <td>'.$row->name.'</td>
                            <td>'.$admin_role.' '.$role.' '.$investor.'</td>
                            <td>'.$row->username.'</td>
                            <td>'.$row->email.'</td>
                            <td>'.$row->phone.'</td>
                            <td><a href="/admin/member/'.$row->id.'" >View</a></td>
                        </tr>
                    ';
                }
            }else {
                $output = '
                    <tr>
                    <td align="center" colspan="5">No Data Found</td>
                    </tr>
                    ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
         
    }
}
