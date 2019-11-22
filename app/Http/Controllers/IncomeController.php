<?php

namespace App\Http\Controllers;

use Auth;
use App\Income;
use App\Sector;
use App\Category;
use App\SubCategory;
use Response;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('Admin');
    }
    
    public function index($id){
        $sector = Sector::find($id);
        $categories = Category::where('sector_id', $id)->pluck('name', 'id');
        $incomes = Income::latest()->take(20)->get();
        return view('admin.pages.income.income_index')->with(compact('categories','incomes'));  
    }

    //=======================================================
    // find
    //=======================================================
    public function find($id) {
        $category_id = $id;
        $data = $this->get_data($category_id);
        echo json_encode($data);
    }

    //=======================================================
    // get data
    //=======================================================
    public function get_data($category_id) {
        $category = Category::find($category_id);
        $category_name = $category->name;

        $sector = Sector::where('id', $category->sector_id)->first();
        $sector_name = $sector->name;

        $sub_categories = SubCategory::where('category_id', $category_id)
                                    ->where('salary', '0')
                                    ->where('active', '1')
                                    ->get();
        $output = '';
        $show = '';
        foreach($sub_categories as $option) {
            $output .= '
            <option value="'.$option->id.'">'.$option->name.'</option>
            ';
            $Incomes = Income::where('sub_category_id', $option->id)->get();
            foreach($Incomes as $income){
                $date = Carbon::parse($income->date)->format('Y-m');
                if($date == date('Y-m')){
                    $show .='
                        <tr>
                            <td>'.$income->date.'</td>
                            <td>'.$income->SubCategory->name.'</td>
                            <td>'.number_format($income->amount, 2).'</td>
                            <td>'.$income->description.'</td>
                            <td>
                                <button  data-toggle="modal"
                                            class="edit_income btn btn-info btn-sm"
                                            data-target="#edit_income_modal"
                                            data-id= "'.$income->id.'"
                                            data-category= "'.$income->SubCategory->Category->id.'"
                                            data-amount="'.$income->amount.'"
                                            data-date="'.$income->date.'"
                                            data-description="'.$income->description.'">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <a href="/admin/income_del/'.$income->id.'" onclick="return ConfirmDelete()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    ';
                }

            }
        }
        
        $data = array(
            'sub_categories'  => $output,
            'show_income'  => $show,
            'sector_name' => $sector_name,
            'edit_url' => url('/admin/edit_income/'.$sector->id),
            'category_name' => $category_name,
        );
        // echo json_encode($data);
        return($data);
        // return('done');
    }

    //==============================================
    // Store Income
    //==============================================
    public function store(Request $request) {
        $store = new Income;
        $store->sub_category_id = $request['subcategory_id'];
        $store->amount = $request['amount'];
        $store->description = $request['description'];
        if(!empty($request['date'])){
            $store->date = $request['date'];
        }else{
            $store->date = Carbon::now()->format('Y-m-d');
        }
        $store->save();

        $sub_category_id = $request['subcategory_id'];
        $sub_category = SubCategory::find($sub_category_id);
        $category_id = $sub_category->Category->id;

        $data = $this->get_data($category_id);

        $data = array_merge($data, array("ajax_status"=>"success","ajax_message"=>"Data Stored"));

        $incomes = Income::latest()->take(20)->get();
        $latest_income = '';
        foreach($incomes as $income){
            $latest_income .='
                <tr>
                    <td>'.$income->date.'</td>
                    <td>'.$income->SubCategory->name.'</td>
                    <td>'.$income->amount.'</td>
                    <td>'.$income->description.'</td>
                    <td>
                        <button  data-toggle="modal"
                                    class="edit_income btn btn-info btn-sm"
                                    data-target="#edit_income_modal"
                                    data-id= "'.$income->id.'"
                                    data-category= "'.$income->SubCategory->Category->id.'"
                                    data-amount="'.number_format($income->amount, 2).'"
                                    data-date="'.$income->date.'"
                                    data-description="'.$income->description.'">
                            <i class="fa fa-edit"></i>
                        </button>
                        <a href="/admin/income_del/'.$income->id.'" onclick="return ConfirmDelete()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            ';
        }
        $data = array_merge($data, array("latest_date"=>$latest_income));
        echo json_encode($data);
        // return back()->with('success', 'Income Saved');
    }

    //==============================================
    // Edit Investment
    //==============================================
    public function update(Request $request) {
        $id = $request['income_id'];
        $update = Income::findOrFail($id);

        $update->amount = $request['amount'];
        $update->description = $request['description'];
        $update->save();    
                 
        $data = array(
            'ajax_status' => 'success',
            'ajax_message'  => 'Data Updated',
            'category'  => $request['category'],
        );

        echo json_encode($data);
    }

    //=======================================================
    // Delete
    //=======================================================
    public function destroy($id){
        $delete = Income::findOrFail($id);
        $delete->delete();
        return back()->with('success', 'Income Deleted');
    }

    //==============================================
    // Filter Income
    //==============================================
    public function show(Request $request, $id) {
        $user = User::find($id);
        $investments = Investment::where('user_id', $id)->whereRaw('MONTH(date) = '.date('n'))->get();
        $total_received = 0;
        foreach($investments as $investment){
            $total_received = $total_received + $investment->amount;
        }
        return view('admin.pages.investment.investment_history_index')->with(compact('user','investments', 'total_received'));
    }

    //==============================================
    // Filter Investments
    //==============================================
    public function filter(Request $request) {
        $date = $request['date'];
        $output = '';
        $total = 0;
        $month = substr($date, 5);
        $year = substr($date, 0, -3);;
        $incomes = Income::whereMonth('date', $month)->whereYear('date', $year)->get();
        
        if(Auth::user()->admin_role == 'super_admin'){
            foreach($incomes as $income) {
                $output .= '
                <tr>
                    <td> '.$income->date.'</td>
                    <td>'.$income->amount.'/=</td>
                    <td>'.$income->description.'</td>
                    <td>
                        <button  data-toggle="modal"
                                    data-target="#edit_income_modal"
                                    data-id= "'.$income->id.'"
                                    data-amount="'.$income->amount.'"
                                    data-description="'.$income->description.'"
                                    class="edit_income btn btn-info btn-sm">
                            <i class="fa fa-edit"></i>
                        </button>
                        <a href="'.url("admin/income_del/".$income->id).'" class="btn btn-danger btn-sm" onclick="return ConfirmDelete()"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                ';
                $total = $total + $income->amount;
            }
        }else{
            foreach($incomes as $income) {
                $output .= '
                <tr>
                    <td> '.$income->date.'</td>
                    <td>'.$income->amount.'/=</td>
                    <td>'.$income->description.'</td>
                </tr>
                ';
                $total = $total + $income->amount;
            }
        }
        

        $data = array(
            'history_data'  => $output,
            'total' => 'Total: '.$total.'/=',
        );
        echo json_encode($data);
    }

    public function sectors() {
        $sectors = Sector::where('type', 1)->get();
        return view('admin.pages.income.sectors_index')->with(compact('sectors'));
    }

    public function IncomeSectorStore (Request $request) {
        $store = new Sector;
        $store->name = $request->input('name');
        $store->type = 1;
        $store->description = $request->input('description');

        $store->save();

        return back()->with('success', 'Sector Added');
    }

}
