<?php

namespace App\Http\Controllers;

use App\Input;
use App\Sector;
use App\Category;
use App\SubCategory;
use App\Income;
use Response;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncomeReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Index view
    //================================================
    public function index(){
        $sectors = Sector::where('type', 1)->pluck('name', 'id');;

        $sector = Sector::where('type', 1)->first();
        if($sector){
            $sector_id = $sector->id;
    
            $categories = Category::where('sector_id', $sector->id )->get();
    
            $fromDate = date('Y-m-01'); 
            $toDate = date('Y-m-d');  
    
            $cat_filters = array();
            foreach($categories as $item){
                array_push($cat_filters, $item->id);
            }
            
            $data = $this->IncomeReport($fromDate, $toDate, $cat_filters, $sector_id );
    
            $total_all = $this->NetIncome($cat_filters, $fromDate, $toDate);
    
            return view('admin.pages.income.report_index')->with(compact('sectors','sector', 'categories', 'data', 'total_all'));
        }
        else{
            return redirect('/admin/income_sectors');
        }
    }

    // Report Data
    //================================================
    public function IncomeReport($fromDate, $toDate, $cat_filters, $sector_id ){
        $data_sector = $sector_id;
        $fromDate = Carbon::createFromFormat('Y-m-d', substr($fromDate, 0, 10));
        $toDate = Carbon::createFromFormat('Y-m-d', substr($toDate, 0, 10));

        $dates = [];

        while ($fromDate->lte($toDate)) {

            $dates[] = $fromDate->copy()->format('Y-m-d');

            $fromDate->addDay();
        }

        $all_data = '';

        foreach($dates as $date){
            $daily_income = 0;
            $day_income = Income::where('date', $date)->get();

            foreach($day_income as $income_d){
                $sub_caregory = SubCategory::findOrFail($income_d->sub_category_id);
                $category = Category::findOrFail($sub_caregory->category_id);
                $sector = Sector::findOrFail($category->sector_id);

                if($data_sector == $sector->id){
                    $daily_income = $daily_income +  $income_d->amount;
                }

            }
            if($daily_income != 0){
                $day  = strtotime($date);
                $monthName = date("F", mktime(0, 0, 0, date('m', $day), 10));
                $all_data .='
                    <tr>
                        <td>'.date('d', $day).' ' .$monthName. '</td>
                        '.$this->DayWiseIncome($date, $cat_filters).'
                    <tr>
                ';
            }
        }

        return ($all_data);

    }

    //=======================================================
    // DayWiseIncome
    //=======================================================
    function DayWiseIncome($date, $cat_filters){

        $income = '';
        $total = 0;

        foreach($cat_filters as $category){

            $filter = Category::with('SubCategory')->where('id', $category)->first();

            foreach($filter->SubCategory as $item){

                $data = Income::where('sub_category_id', $item->id)->whereDate('date', $date)->get();
                
                if ($data){
                    $c_income = 0;
                    foreach($data as $s_data){
                        $c_income = $c_income + $s_data->amount;
                    }
                    if($c_income == 0){
                        $income .= '<td></td>';
                    }else{
                        $income .= '<td>'.number_format($c_income, 2).' tk/=</td>';
                    }
                    $total = $total + $c_income;
                }
                else{
                    $income .= '<td></td>';
                }
            }
        }
        $income .= '<td>'.number_format($total, 2).' tk/=</td>';
        return ($income);
    }
    
    //=======================================================
    // NetVerticalIncome
    //=======================================================
    public function NetIncome($cat_filters, $fromDate, $toDate){

        $total_all = array();
        $netTotal = 0;

        foreach($cat_filters as $category){

            $filter = Category::with('SubCategory')->where('id', $category)->first();

            foreach($filter->SubCategory as $item){
                $total = 0;
                $Incomes = Income::where('sub_category_id', $item->id)->whereBetween('date', [$fromDate, $toDate])->get();
                foreach($Incomes as $Income){
                    $total = $total + $Income->amount; 
                }
                $netTotal = $netTotal + $total;
                array_push($total_all, $total);
            }
        }
        array_push($total_all, $netTotal);
        return ($total_all);
    }

    //=======================================================
    // Filter: date & Category
    //=======================================================
    public function filter(Request $request) {

        // getting data
        //-------------------------------------
        $cat_filters = $request->id;
        $sector = $request->sector;

        if (isset($sector)){
            $sector = Sector::findOrFail($sector);
            $sector_id = $sector->id;
        }
        else{
            $sector = Sector::where('type', 1)->first();
            $sector_id = $sector->id;
        }

        if($cat_filters == null){
            $categories = Category::where('sector_id', $sector->id)->get();

            $cat_filters = array();
            foreach($categories as $item){
                array_push($cat_filters, $item->id);
            }
        }
        
        $date = $request->date;

        $fromDate = substr($date, 0, strpos($date, " - "));
        $fromDate = date('Y-m-d', strtotime($fromDate));
        $toDate = substr($date, -10);
        $toDate = date('Y-m-d', strtotime($toDate));

        $all_data = $this->IncomeReport($fromDate, $toDate, $cat_filters, $sector_id);

        // getting table Headings
        //-------------------------------------
        $report_cat = '<th></th>';
        $report_sub = '<th style="width: 60px">Date</th>';

        foreach($cat_filters as $item){
            $category  = Category::where('id', $item)->first();
            $report_cat .=  '<th colspan= "'.count($category->SubCategory).'">'.$category->name.'</th>';
            
            foreach($category->SubCategory as $sub){
                $report_sub .= '<th>'.$sub->name.'</th>';
            }
        }

        $report_cat .=  '<th rowspan="2">Total</th>';


        // getting table Footer
        //-------------------------------------
        $footer_data =  $this->NetIncome($cat_filters, $fromDate, $toDate);
        $report_footer = '<th>Total</th>';
        foreach($footer_data as $data){
            $report_footer .= '<th class="nowrap">'.number_format($data, 2).' tk/=</th>';
        }
        

        // send table data
        //-------------------------------------
        $data = array(
            'all_data'  => $all_data,
            'report_cat'  => $report_cat,
            'report_sub'  => $report_sub,
            'report_footer'  => $report_footer,
        );
        echo json_encode($data);
    }

    //=======================================================
    // Filter: Sector
    //=======================================================
    public function sectorfilter(Request $request){
        // getting data
        //-------------------------------------
        $sector = Sector::findOrFail($request->id);
        $sector_id = $sector->id;
        $sector_name = $sector->name;

        $categories = Category::where('sector_id', $sector->id)->get();

        // get categories
        // --------------------------------------
        $sector_categories = '';
        foreach($categories as $category){
            $sector_categories .= '
                <div class="category_check">
                    <label>
                        <input class="report_checkbox" type="checkbox" name="category[]" value="'.$category->id.'">
                        '.$category->name.'
                    </label>
                </div>
            ';
        }

        $cat_filters = array();
        foreach($categories as $item){
            array_push($cat_filters, $item->id);
        }
        
        $date = $request->date;

        $fromDate = substr($date, 0, strpos($date, " - "));
        $fromDate = date('Y-m-d', strtotime($fromDate));
        $toDate = substr($date, -10);
        $toDate = date('Y-m-d', strtotime($toDate));

        $all_data = $this->IncomeReport($fromDate, $toDate, $cat_filters, $sector_id);

        // getting table Headings
        //-------------------------------------
        $report_cat = '<th></th>';
        $report_sub = '<th style="width: 60px">Date</th>';

        foreach($cat_filters as $item){
            $category  = Category::where('id', $item)->first();
            $report_cat .=  '<th colspan= "'.count($category->SubCategory).'">'.$category->name.'</th>';
            foreach($category->SubCategory as $sub){
                $report_sub .= '<th>'.$sub->name.'</th>';
            }
        }

        $report_cat .=  '<th rowspan="2">Total</th>';

        // getting table Footer
        //-------------------------------------
        $footer_data =  $this->NetIncome($cat_filters, $fromDate, $toDate);
        $report_footer = '<th>Total</th>';
        foreach($footer_data as $data){
            $report_footer .= '<th class="nowrap">'.number_format($data, 2).' tk/=</th>';
        }
        // send table data
        //-------------------------------------
        $data = array(
            'all_data'  => $all_data,
            'report_cat'  => $report_cat,
            'report_sub'  => $report_sub,
            'sector_categories' => $sector_categories,
            'sector_name' => $sector_name,
            'report_footer'  => $report_footer,
        );
        echo json_encode($data);
    }

}
