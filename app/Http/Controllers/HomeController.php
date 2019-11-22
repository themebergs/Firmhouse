<?php

namespace App\Http\Controllers;

use App\User;
use App\Investment;
use App\Income;
use App\Expense;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->admin_role == 'user'){
            return redirect('/admin/report');
        }else{
        
            $date = today();
            $Expenses = Expense::whereYear('date', $date->format('Y'))->whereMonth('date', $date->format('m'))->get();
            $MonthlyExpense = 0;
            foreach($Expenses as $expense){
                $MonthlyExpense = $MonthlyExpense + $expense->amount;
            }
    
            $Investments = Investment::whereYear('date', $date->format('Y'))->whereMonth('date', $date->format('m'))->get();
            $MonthlyInvestment = 0;
            foreach($Investments as $investment){
                $MonthlyInvestment = $MonthlyInvestment + $investment->amount;
            }
    
            $Incomes = Income::whereYear('date', $date->format('Y'))->whereMonth('date', $date->format('m'))->get();
            $MonthlyIncome = 0;
            foreach($Incomes as $Income){
                $MonthlyIncome = $MonthlyIncome + $Income->amount;
            }
    
            $total_user = User::where('investor', 1)->where('active', 1)->get()->count();
            return view('admin.pages.home.index')->with(compact('total_user', 'MonthlyExpense', 'MonthlyInvestment', 'date', 'MonthlyIncome'));  
        }
    }
}
