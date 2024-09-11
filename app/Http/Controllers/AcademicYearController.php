<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = new AcademicYear();
        $all_data['academic_year']=$data->latest()->get();
        return view('admin.academic_year_list',$all_data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.academic_year');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $data = new AcademicYear();
        $data ->name = $request->name;
        $data->save();
        return redirect()->route('academic-year.create')->with('success','academic year save successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicYear $academicYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['academic_year'] = AcademicYear::find($id);
        return view('admin.academic-year-edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $data = AcademicYear::find($id);
        $data->name = $request->name;
        $data->update();
        return redirect()->route('academic-year.index')->with('success','successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $data = AcademicYear::find($id);
        $data->delete();
        return redirect()->route('academic-year.index')->with('success','successfully delete ');
    }
}
