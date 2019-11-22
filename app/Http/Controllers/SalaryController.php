<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\User;
use App\Expense;
use App\salary;
use App\Category;
use App\SubCategory;
use Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\SalaryRequest;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Admin');
    }

    public function index()
    {
        $title = 'Employee';
        $Users = User::all()->where('role_id', '!=', '')->pluck('name', 'id');

        $setSalary = SubCategory::where('salary', 1)->get();

        // return(count($setSalary));
        // return view('admin.pages.salary.salary_index')->with(compact('title', 'Users'));  
        if(count($setSalary) == 1){
            return view('admin.pages.salary.salary_index')->with(compact('title', 'Users'));  
        }
        else{
            // $categories = Category::with('SubCategory')->get()->pluck('name', 'id');
            // return view('admin.pages.salary.setsalary')->with(compact('categories')); 
            Session::flash('error', 'Some thing went wrong!!');
            return redirect('/admin/sectors');
        }
    }

    public function set(Request $request, $id){
        $id = $id;

        $update = SubCategory::findOrFail($id);

        if($update->salary == 0){
            $update->salary = 1;
            $update->save();
            $response = array(
                'ajax_status' => 'success',
                'ajax_message' => 'Field set as Salary Field',
            );
        }
        else{
            $update->salary = 0;
            $update->save();
            $response = array(
                'ajax_status' => 'success',
                'ajax_message' => 'Field Unset',
            );
        }

        return Response::json( $response );

    }

    public function finduser(Request $request)
    {
        $id = $request['id'];
        $get = User::find($id);

        if($get->user_image != '' || $get->user_image != NULL){
            $image = asset('laravel/public/images/user/'.$get->user_image);
        }else{
            $image = asset('images/avater.png');
        }

        $history = Expense::where('salary', '1')->where('user_id', $id)->where( DB::raw('MONTH(date)'), '=', date('n') )->get();
        $total = 0;
        if(count($history) > 0){
            foreach($history as $sum){
                $amount = $sum->amount;
                $total = $total + $amount;
            }
        }

        $salary_default = salary::where('user_id', $id)->first();
        $monthly_salary = $salary_default->amount;
        $can_receive = $monthly_salary - $total;
        $last_received = Expense::where('salary', '1')->where('user_id', $id)->orderBy('date', 'desc')->first();
       
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
            'role' => $get->Role->name,
            'address' => $get->address,
            'member_since' => $get->date,
            'link' => '/admin/member/'.$get->id,
            'total' => $total,
            'last_received' => $last_amount,
            'last_date' => $last_date,
            'monthly_salary' => $monthly_salary,
            'due_amount' => $can_receive,
            'history_link' => '/admin/salary/user/'.$id,
        );
        return Response::json( $response ); 
    }

    public function store(SalaryRequest $request)
    {
        $user_id = $request['user_id'];
        
        $history = Expense::where('salary', '1')->where('user_id', $user_id)->where( DB::raw('MONTH(date)'), '=', date('n') )->get();
        $total = 0;
        if(count($history) > 0){
            foreach($history as $sum){
                $amount = $sum->amount;
                $total = $total + $amount;
            }
        }
        
        $user = User::find($user_id);
        $salary_default = salary::where('user_id', $user_id)->first();
        $monthly_salary = $salary_default->amount;
        

        $total_with_new = $total + $request['amount'];

        if($total_with_new > $monthly_salary){
            $response = array(
                'ajax_status' => 'Failed',
                'ajax_message' => 'Salary Limit Exit for this Month',
            );
    
            return Response::json( $response );
        }else{

            $subcategory = SubCategory::where('salary', '1')->first();
            $store = new Expense;
            $store->sub_category_id = $subcategory->id;
            $store->salary = '1';
            $store->user_id = $user_id;
            $store->amount = $request['amount'];
            $store->description = $request['description'];
            if(!empty($request['date'])){
                $store->date = $request['date'];
            }else{
                $store->date = Carbon::now()->format('Y-m-d');
            }
            $total = $total + $request['amount'];
            $can_receive = $monthly_salary - $total;
            $store->save();
            
    
            $last_received = Expense::where('salary', '1')->where('user_id', $store->user_id)->orderBy('date', 'desc')->first();
           
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
                'total' => $total,
                'last_received' => $last_amount,
                'last_date' => $last_date,
                'due_amount' => $can_receive,
            );
    
            return Response::json( $response );
        }
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);
        $salaries = Expense::where('salary', '1')->where('user_id', $id)->whereRaw('MONTH(date) = '.date('n'))->get();
        $total_received = 0;
        foreach($salaries as $salary){
            $total_received = $total_received + $salary->amount;
        }
        return view('admin.pages.salary.salary_history_index')->with(compact('user','salaries', 'total_received'));
    }

    public function filter(Request $request)
    {
        $date = $request['date'];
        $id = $request['id'];
        $output = '';
        $total = 0;
        $month = substr($date, 5);
        $year = substr($date, 0, -3);;
        $salaries = Expense::where('salary', '1')->where('user_id', $id)->whereMonth('date', $month)->whereYear('date', $year)->get();
        foreach($salaries as $salary) {
            $output .= '
            <tr>
                <td> '.$salary->date.'</td>
                <td>'.$salary->amount.'/=</td>
                <td>'.$salary->description.'</td>
            </tr>
            ';
            $total = $total + $salary->amount;
        }

        $data = array(
            'history_data'  => $output,
            'total' => 'Total: '.$total.'/=',
        );
        echo json_encode($data);
    }
}
