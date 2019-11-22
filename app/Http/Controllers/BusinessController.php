<?php

namespace App\Http\Controllers;

use App\BusinessSettings;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('SuperAdmin');
    }

    public function index()
    {
        $business = BusinessSettings::first();
        if(empty($business)){
            return view('admin.pages.business.business_new_index'); 
        }else{
            return view('admin.pages.business.business_index')->with(compact('business')); 

        }
    }
}
