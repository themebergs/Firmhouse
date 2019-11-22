<?php

namespace App\Http\Controllers;

use App\Sector;
use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Requests\SectorRequest;

class SectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Admin');
    }

    public function index()
    {
        $Sectors = Sector::where('type', 0)->get();  
        return view('admin.pages.sectors.sectors_index')->with(compact('Sectors')); 
    }

    public function store(SectorRequest $request)
    {
        $store = new Sector;
        $store->name = $request->input('name');
        $store->description = $request->input('description');

        $store->save();

        return back()->with('success', 'Sector Added');
    }

    public function show($id)
    {
        $Sector = Sector::find($id);
        $CatagoryList = Sector::find($id)->Category;
        return view('admin.pages.sectors.single_sector_index')->with(compact('Sector','CatagoryList')); 
    }

    public function edit($id)
    {
        $Sector = Sector::find($id);
        if ($Sector->type == 0){
            $Sectors = Sector::where('type',0)->get();  
        }
        else{
            $Sectors = Sector::where('type', 1)->get(); 
        }
        return view('admin.pages.sectors.sectors_index')->with(compact('Sector','Sectors')); 
    }

    public function update(SectorRequest $request, $id)
    {
        $update = Sector::findOrFail($id);

        $update->name = $request['name'];
        $update->description = $request['description'];
        $update->save();             
        return back()->with('success', 'Sector Updated');
    }

    public function destroy($id)
    {
        $delete = Sector::find($id); 

        $CategoryList = Sector::find($id)->Category;
        foreach($CategoryList as $del){
            $delete_child = Category::find($del->id); 

            $SubCategoryList = Category::find($delete_child->id)->SubCategory;
            foreach($SubCategoryList as $del){
                $delete_child_c = SubCategory::find($del->id); 
                $delete_child_c->delete();
            }

            $delete_child->delete();
        }

        $delete->delete();
        return back()->with('success', 'Sector Deleted');
    }
}
