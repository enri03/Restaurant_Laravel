<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {  
        $category = Category::paginate(3);
        return view("managment.category")->with('categories',$category);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("managment.createCategory");
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255'
        ]);
        $category = new Category;
        $category-> name = $request->name;
        $category->save();
        $request->session()->flash("status",$request->name ." is saved succesfully");
        return (redirect("/management/category"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        return view("managment.editCategory")->with('category',$category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255'
        ]);
        $category =Category::findorFail($id);
        $category->name = $request->name;
        $category->save();
        $request->session()->flash("status",$request->name ." is updated succesfully");
        return (redirect("/management/category"));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::destroy($id);
        Session()->flash("status","Category deleted  succesfully");
        return (redirect("/management/category"));
    }
}