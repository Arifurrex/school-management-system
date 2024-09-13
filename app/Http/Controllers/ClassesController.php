<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = new Classes();
        $all_data['classes']=$data->latest()->get();
        return view('admin.class.class-list',$all_data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.class.class');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $data = new Classes();
        $data ->name = $request->name;
        $data->save();
        return redirect()->route('class.create')->with('success','academic year save successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classes $classes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['classes'] = Classes::find($id);
        return view('admin.class.class-edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data =Classes::find($id);
        $data->name = $request->name;
        $data->update();
        return redirect()->route('class.index')->with('success','successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $data = Classes::find($id);
        $data->delete();
        return redirect()->route('class.index')->with('success','successfully delete ');
    }
}
