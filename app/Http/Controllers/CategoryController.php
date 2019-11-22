<?php

namespace App\Http\Controllers;

use App\Sector;
use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Admin');
    }

    public function index()
    {
        return redirect('/admin/sectors');
    }

    public function store(CategoryRequest $request)
    {
        $store = new Category;
        $store->sector_id = $request->input('sector_id');
        $store->name = $request->input('name');
        $store->description = $request->input('description');

        $store->save();

        return back()->with('success', 'Category Added');
    }

    public function show($id)
    {
        $Category = Category::find($id);
        $SubCategoryList = Category::find($id)->SubCategory;
        return view('admin.pages.category.index')->with(compact('Category','SubCategoryList')); 
    }

    public function edit($id)
    {
        $Catagory = Category::find($id);
        $Sector = Category::find($id)->Sector;
        $CatagoryList = Sector::find($Sector->id)->Category;
        return view('admin.pages.sectors.single_sector_index')->with(compact('Catagory', 'Sector', 'CatagoryList')); 
    }

    public function update(CategoryRequest $request, $id)
    {
        $update = Category::findOrFail($id);

        $update->name = $request['name'];
        $update->description = $request['description'];
        $update->save();             
        return back()->with('success', 'Category Updated');
    }

    public function destroy($id)
    {
        $delete = Category::find($id); 
        $Sector = Category::find($id)->Sector;

        $SubCategoryList = Category::find($id)->SubCategory;
        foreach($SubCategoryList as $del){
            $delete_child = SubCategory::find($del->id); 
            $delete_child->delete();
        }

        $delete->delete();
        return redirect('admin/sectors/'.$Sector->id)->with('success', 'Category Deleted');
    }
}
