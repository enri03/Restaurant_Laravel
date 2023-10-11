<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $tables = Table::all();
        return view('managment.tabel')->with('tables',$tables);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('managment.createTabel');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255'
        ]);
        $table = new Table;
        $table->name = $request->name;
        $table->save();
        $request->session()->flash("status",$request->name ." is saved succesfully");
        return (redirect("/management/table"));
        
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
        $table = Table::findOrFail($id);
        return view('managment.editTable')->with('table',$table);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:tables|max:255'
        ]);
        $table = Table::findOrFail($id); 
        $table->name = $request->name;
        $table->save();
        $request->session()->flash("status","Table data updated succesfully");
        return (redirect("/management/table"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Table::destroy($id);
        Session()->flash("status","Table deleted  succesfully");
        return (redirect("/management/table"));
    }
}
