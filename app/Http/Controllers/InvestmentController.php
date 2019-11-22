<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Investment;
use Response;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Admin');
    }

    //==============================================
    // Find User
    //==============================================
    public function finduser(Request $request) {
        $id = $request['id'];
        $get = User::find($id);

        if($get->user_image != '' || $get->user_image != NULL){
            $image = asset('laravel/public/images/user/'.$get->user_image);
        }else{
            $image = asset('images/avater.png');
        }

        if($get->admin_role == 'super_admin'){
            $role = 'Super Admin';
        }
        elseif($get->admin_role == 'admin'){
            $role = 'Admin';
        }
        else{
            $role = 'User';
        }
        if (!empty($get->role_id)){
            $role .= ', '.$get->Role->name;
        }
        if ($get->investor == '1'){
            $role .= ', Investor';
        }

        $history = Investment::where('user_id', $id)->where( DB::raw('MONTH(date)'), '=', date('n') )->get();
        $total = 0;
        if(count($history) > 0){
            foreach($history as $sum){
                $amount = $sum->amount;
                $total = $total + $amount;
            }
        }

        $last_received = Investment::where('user_id', $id)->orderBy('date', 'desc')->first();
    
        if(!empty($last_received->amount)){
            $last_amount = $last_received->amount;
            $last_date =  $last_received->date;
        }else{
            $last_amount = 0;
            $last_date = '';
        }

        $response = array(
            'image' => $image,
            'name' => $get->name,
            'email' => $get->email,
            'phone' => $get->phone,
            'role' => $role,
            'address' => $get->address,
            'member_since' => $get->created_at->format('Y-m-d'),
            'user_link' => '/admin/member/'.$get->id,
            'history_link' => '/admin/investment/user/'.$id,
            'total_investment' => $total,
            'last_investment' => $last_amount,
            'last_investment_date' => $last_date,
        );
        return Response::json( $response ); 
    }
    //==============================================
    // Index
    //==============================================
    public function index() {
        $Users = User::orderBy('name', 'asc')->where('investor', 1)->get()->pluck('name', 'id');
        return view('admin.pages.investment.investments_index')->with(compact('Users')); 
    }

    //==============================================
    // Store
    //==============================================
    public function store(Request $request)
    {
        $user_id = $request['user_id'];
        
        $history = Investment::where('user_id', $user_id)->where( DB::raw('MONTH(date)'), '=', date('n') )->get();
        $total = 0;
        if(count($history) > 0){
            foreach($history as $sum){
                $amount = $sum->amount;
                $total = $total + $amount;
            }
        }
        
        $user = User::find($user_id);
        $update = User::findOrFail($user_id);
        $update->investor = '1';
        $update->save();    

        $total_with_new = $total + $request['amount'];

        $store = new Investment;
        $store->user_id = $user_id;
        $store->amount = $request['amount'];
        $store->description = $request['description'];
        if(!empty($request['date'])){
            $store->date = $request['date'];
        }else{
            $store->date = Carbon::now()->format('Y-m-d');
        }
        $total = $total + $request['amount'];
        $store->save();
        

        $last_received = Investment::where('user_id', $store->user_id)->orderBy('date', 'desc')->first();
        
        if(!empty($last_received->amount)){
            $last_amount = $last_received->amount;
            $last_date =  $last_received->date;
        }else{
            $last_amount = 0;
            $last_date = '';
        }

        $response = array(
            'ajax_status' => 'success',
            'ajax_message' => 'Salary Added',
            'total_investment' => $total,
            'last_investment' => $last_amount,
            'last_investment_date' => $last_date,
        );
    
        return Response::json( $response );
    }

    //==============================================
    // Show History
    //==============================================
    public function show(Request $request, $id) {
        $user = User::find($id);
        $investments = Investment::where('user_id', $id)->whereRaw('MONTH(date) = '.date('n'))->get();
        $all_investments = Investment::where('user_id', $id)->get();
        $total_received = 0;
        $total_received_all = 0;
        foreach($investments as $investment){
            $total_received = $total_received + $investment->amount;
        }
        foreach($all_investments as $investment){
            $total_received_all = $total_received_all + $investment->amount;
        }
        return view('admin.pages.investment.investment_history_index')->with(compact('user','investments','all_investments', 'total_received', 'total_received_all'));
    }

    //==============================================
    // Filter Investments
    //==============================================
    public function filter(Request $request) {
        $date = $request['date'];
        $id = $request['id'];
        $output = '';
        $total = 0;
        $month = substr($date, 5);
        $year = substr($date, 0, -3);;
        $investments = Investment::where('user_id', $id)->whereMonth('date', $month)->whereYear('date', $year)->get();
        if(Auth::user()->admin_role == 'super_admin'){
            foreach($investments as $investment) {
                $output .= '
                <tr>
                    <td> '.$investment->date.'</td>
                    <td>'.$investment->amount.'/=</td>
                    <td>'.$investment->description.'</td>
                    <td>
                        <button  data-toggle="modal"
                                    data-target="#edit_investment_modal"
                                    data-id= "'.$investment->id.'"
                                    data-amount="'.$investment->amount.'"
                                    data-description="'.$investment->description.'"
                                    class="edit_investment btn btn-info btn-sm">
                            <i class="fa fa-edit"></i>
                        </button>
                        <a href="'.url("admin/investment_del/".$investment->id).'" class="btn btn-danger btn-sm" onclick="return ConfirmDelete()"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                ';
                $total = $total + $investment->amount;
            }
        }else{
            foreach($investments as $investment) {
                $output .= '
                <tr>
                    <td> '.$investment->date.'</td>
                    <td>'.$investment->amount.'/=</td>
                    <td>'.$investment->description.'</td>
                </tr>
                ';
                $total = $total + $investment->amount;
            }
        }

        $data = array(
            'history_data'  => $output,
            'total' => 'Total: '.$total.'/=',
        );
        echo json_encode($data);
    }

    //==============================================
    // All Investments
    //==============================================
    public function all() {
        $Investors = User::where('investor' ,'1')->where('active', 1)->get();
        
        $all_investment = Investment::all();
        $total_investment = 0;
        
        
        foreach($all_investment as $investment){
            $total_investment = $total_investment + $investment->amount;
        }
        
        $output = '';
        foreach($Investors as $Investor){
            $total = 0;
            
            $percentage = 0;
            $investment = Investment::where('user_id', $Investor->id)->get();
            foreach($investment as $amount){
                $total =  $total + $amount->amount;
            }
            
            if($total_investment == 0){
                $total_investment = 1;
            }
            
            $percentage = $total/$total_investment*100;
            
            $output .= '
                <tr>
                    <td> '.$Investor->id.'</td>
                    <td>'.$Investor->name.'</td>
                    <td>'.number_format("$total",2).' tk/=</td>
                    <td>'.number_format($percentage,2).'%</td>
                    <td><a href="/admin/investment/user/'.$Investor->id.'"><i class="fa fa-eye"></i> &nbsp; View</a></td>
                </tr>
                ';
        }
        return view('admin.pages.investment.investment_all_index')->with(compact('output', 'total_investment'));
    }

    //==============================================
    // Edit Investment
    //==============================================
    public function update(Request $request){
        $id = $request['invest_id'];
        $update = Investment::findOrFail($id);

        $update->amount = $request['amount'];
        $update->description = $request['description'];
        $update->save();             
        return back()->with('success', 'investment Updated');
        // return ($id);
    }

    //=======================================================
    // Delete
    //=======================================================
    public function destroy($id){
        $delete = Investment::findOrFail($id);
        $delete->delete();
        return back()->with('success', 'Investment Deleted');
    }
}
