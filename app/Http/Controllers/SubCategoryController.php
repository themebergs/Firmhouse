<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class SubCategoryController extends Controller
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
        $store = new SubCategory;
        $store->category_id = $request->input('category_id');
        $store->name = $request->input('name');
        $store->description = $request->input('description');

        $store->save();

        return back()->with('success', 'Sub Category Added');
    }

    public function edit($id)
    {
        $SubCategory = SubCategory::find($id);
        $Category = SubCategory::find($id)->Category;
        $SubCategoryList = Category::find($Category->id)->SubCategory;
        return view('admin.pages.category.index')->with(compact('SubCategory', 'Category', 'SubCategoryList')); 
    }

    public function update(CategoryRequest $request, $id)
    {
        $update = SubCategory::findOrFail($id);

        $update->name = $request['name'];
        $update->description = $request['description'];
        $update->save();             
        return back()->with('success', 'Sub Category Updated');
    }

    public function destroy($id)
    {
        $Category = SubCategory::find($id)->Category;
        $delete = SubCategory::find($id); 
        $delete->delete();
        return redirect('admin/categories/'.$Category->id)->with('success', 'Sub Category Deleted');
    }
}
