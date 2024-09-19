<?php

namespace App\Http\Controllers;

use App\Models\feeStructure;
use App\Models\AcademicYear;
use App\Models\academicClass;
use App\Models\FeeHead;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $feeStructure = FeeStructure::query()->with(['FeeHead', 'AcademicYear', 'academicClass'])->latest();  // here FeeHead,AcademicYear,academicClass comes from feeStructure model when i define those function
        
        if($request->filled('academic_class_id')){
           $feeStructure->where('academic_class_id',$request->get('academic_class_id'));
        }
        if($request->filled('academic_year_id')){
            $feeStructure->where('academic_year_id',$request->get('academic_year_id'));
         }
        $data['feeStructure']=$feeStructure->get();
        
        $data['classes'] = AcademicClass::all();
        $data['FeeHeads'] = FeeHead::all();
        $data['AcademicYears'] = AcademicYear::all();

        return view('admin.FeeStructure.FeeStructure-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['classes'] = AcademicClass::all();
        $data['FeeHeads'] = FeeHead::all();
        $data['AcademicYears'] = AcademicYear::all();

        return view('admin.FeeStructure.FeeStructure', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required',
            'fee_head_id' => 'required',
            'academic_class_id' => 'required',
        ]);
        FeeStructure::create($request->all());
        return redirect()->route('FeeStructure.create')->with('success', 'Fee added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(FeeStructure $feeStructure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeeStructure $feeStructure,$id)
    {
        $data['feeStructure']=feeStructure::find($id);
        $data['classes'] = AcademicClass::all();
        $data['FeeHeads'] = FeeHead::all();
        $data['AcademicYears'] = AcademicYear::all();
        return view('admin.FeeStructure.FeeStructure-edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeeStructure $feeStructure,$id)
    {
        $data = feeStructure::find($id);
        $data->academic_class_id = $request->academic_class_id;
        $data->academic_year_id = $request->academic_year_id;
        $data->fee_head_id  = $request->fee_head_id ;
        $data->january = $request->january;
        $data->february = $request->february;
        $data->march = $request->march;
        $data->april = $request->april;
        $data->may = $request->may;
        $data->june = $request->june;
        $data->july = $request->july;
        $data->august = $request->august;
        $data->september = $request->september;
        $data->october = $request->october;
        $data->november = $request->november;
        $data->december = $request->december;
        $data->update();
        return redirect()->route('FeeStructure.index')->with('success','successfully update your fee');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $data = feeStructure::find($id);
        $data->delete();

        return redirect()->back()->with('success','successfully delete');
    }
}
