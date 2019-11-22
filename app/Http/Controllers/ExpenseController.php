<?php

namespace App\Http\Controllers;

use App\User;
use App\Expense;
use App\Sector;
use App\Category;
use App\SubCategory;
use App\salary;
use Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ExpenseRequest;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Admin');
    }

    //=======================================================
    // Index
    //=======================================================
    public function index() {
    }

    //=======================================================
    // show
    //=======================================================
    public function show($id) {
        $sector = Sector::find($id);
        $categories = Category::where('sector_id', $id)->pluck('name', 'id');
        $expenses = Expense::latest()->take(20)->get();
        return view('admin.pages.expense.expense_index')->with(compact('categories','expenses'));  
    }

    //=======================================================
    // store
    //=======================================================
    public function store(Request $request) {
        $store = new Expense;
        $store->sub_category_id = $request['subcategory_id'];
        $store->amount = $request['amount'];
        $store->description = $request['description'];
        if(!empty($request['date'])){
            $store->date = $request['date'];
        }else{
            $store->date = Carbon::now()->format('Y-m-d');
        }
        $store->save();
        

        // $sub_category_id = $request['subcategory_id'];
        // $sub_category = SubCategory::find($sub_category_id);
        // $category_id = $sub_category->Category->id;

        // $data = $this->get_data($category_id);

        // $data = array_merge($data, array("ajax_status"=>"success","ajax_message"=>"Data Stored"));

        // echo json_encode($data);
        return back()->with('success', 'Data Stored');
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

            foreach($option->Expense as $expense){
                $date = Carbon::parse($expense->date)->format('Y-m');
                if($date == date('Y-m')){
                    $show .='
                        <tr>
                            <td>'.$expense->date.'</td>
                            <td>'.$expense->SubCategory->name.'</td>
                            <td>'.$expense->amount.'</td>
                            <td>'.$expense->description.'</td>
                            <td>
                                <button  data-toggle="modal"
                                            class="edit_expense btn btn-info btn-sm"
                                            data-target="#edit_expense_modal"
                                            data-id= "'.$expense->id.'"
                                            data-category= "'.$expense->SubCategory->Category->id.'"
                                            data-amount="'.$expense->amount.'"
                                            data-date="'.$expense->date.'"
                                            data-description="'.$expense->description.'">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <a href="/admin/expense_del/'.$expense->id.'" onclick="return ConfirmDelete()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    ';
                }

            }
        }
        
        $data = array(
            'sub_categories'  => $output,
            'show_expense'  => $show,
            'sector_name' => $sector_name,
            'edit_url' => url('/admin/edit_expense/'.$sector->id),
            'category_name' => $category_name,
        );
        // echo json_encode($data);
        return($data);
    }
    //=======================================================
    // Update
    //=======================================================
    public function update(Request $request) {
        $id = $request['expense_id'];
        $update = Expense::findOrFail($id);

        $update->amount = $request['amount'];
        $update->description = $request['description'];
        $update->date = $request['date'];
        $update->save();             
        
        $data = array(
            'ajax_status' => 'success',
            'ajax_message'  => 'Data Updated',
            'category'  => $request['category'],
        );

        echo json_encode($data);
    }

    
    public function delete($id){
        $delete = Expense::find($id); 
        $delete->delete();
        return back()->with('success', 'Expense Deleted');
    }

//==================================
}