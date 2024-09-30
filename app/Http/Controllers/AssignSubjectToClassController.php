<?php

namespace App\Http\Controllers;

use App\Models\academicClass;
use App\Models\assignSubjectToClass;
use App\Models\subject;
use Illuminate\Cache\RedisTagSet;
use Illuminate\Http\Request;

class AssignSubjectToClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query=assignSubjectToClass::query()->with('academicClasses','subjects')->latest();
        if($request->filled('class_id')){
            $query->where('class_id',$request->get('class_id'));
        }
        if($request->filled('subject_id')){
            $query->where('subject_id',$request->get('subject_id'));
        }
        $data['assignSubjectToClasses']=$query->get();
        $data['classes']=academicClass::get();
        $data['subjects']=subject::get();
        return view('admin.assignSubjectToClass.assignSubjectToClass-index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['subjects'] = subject::latest()->get();
        $data['classes'] = academicClass::latest()->get();
        $data['assignSubjectToClasses'] = assignSubjectToClass::latest()->get();
        return view('admin.assignSubjectToClass.assignSubjectToClass-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => "required",
            'subjects_ids' => "required|array",
        ]);

        $class_id = $request->class_id;
        $all_subject_id = $request->subjects_ids;

        foreach ($all_subject_id as $subject_id) {
            assignSubjectToClass::updateOrCreate(
                // প্রথম প্যারামিটার: কোন কোন শর্তের ভিত্তিতে রেকর্ড খুঁজতে হবে
                [
                    'class_id' => $class_id, // নির্দিষ্ট ক্লাস আইডি
                    'subject_id' => $subject_id // নির্দিষ্ট সাবজেক্ট আইডি
                ],
                // দ্বিতীয় প্যারামিটার: খুঁজে পেলে কী কী আপডেট হবে, না পেলে নতুন রেকর্ডের জন্য কী মান থাকবে
                [
                    'class_id' => $class_id, // ক্লাস আইডি
                    'subject_id' => $subject_id // সাবজেক্ট আইডি
                ]

            );
        };

        return redirect()->back()->with('success','successfully insert subject in class');
    }

    /**
     * Display the specified resource.
     */
    public function show(assignSubjectToClass $assignSubjectToClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(assignSubjectToClass $assignSubjectToClass,$id)
    {
        $data['assignSubjectToClass']=assignSubjectToClass::with(['academicClasses','subjects'])->find($id);
        $data['subjects'] = subject::latest()->get();

        return view('admin.assignSubjectToClass.assignSubjectToClass-edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, assignSubjectToClass $assignSubjectToClass,$id)
    {

        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
        ]);

        assignSubjectToClass::find($id)->update($request->all());
        return redirect()->back()->with('success','successfully update');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(assignSubjectToClass $assignSubjectToClass,$id)
    {
        assignSubjectToClass::find($id)->delete();
        return redirect()->back()->with('success','successfully delete');
    }
}
