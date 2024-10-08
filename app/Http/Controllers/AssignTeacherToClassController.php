<?php

namespace App\Http\Controllers;

use App\Models\academicClass;
use App\Models\assignSubjectToClass;
use App\Models\assignTeacherToClass;
use App\Models\subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignTeacherToClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = assignTeacherToClass::query()->with(['academicClasses', 'subjects', 'teacher'])->latest();

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->get('class_id'));
        }
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->get('subject_id'));
        }
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->get('teacher_id'));
        }
        $data['assignTeacherToClasses'] = $query->get();

        $data['classes'] = academicClass::get();
        $data['subjects'] = subject::get();
        $data['teacher'] = User::where('role', 'teacher')->get();

        return view('admin.assignTeacherToClass.assignTeacherToClass-index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['teachers'] = User::where('role', 'teacher')->get();
        $data['subjects'] = subject::latest()->get();
        $data['classes'] = academicClass::latest()->get();
        $data['assignSubjectToClass'] = assignSubjectToClass::with('academicClasses')->get();

        $data['assignTeacherToClass'] = assignTeacherToClass::latest()->get();
        return view('admin.assignTeacherToClass.assignTeacherToClass-create', $data);
    }

    // AJAX
    public function fetchSubjects(Request $request)
    {
        $classId = $request->class_id;
        $assignSubjectToClass = assignSubjectToClass::where('class_id', $classId)
            ->with(['subjects', 'academicClasses'])
            ->get();


        $output = '';
        foreach ($assignSubjectToClass as $sub) {
            $output .= '<div class="form-group col-md-12">
                <input type="checkbox" id="subject-' . $sub->id . '" name="subjects_ids[]" value="' . $sub->subjects->id . '">
                <label for="subject-' . $sub->id . '">' . $sub->subjects->name . '</label>
            </div>';
        }

        return response()->json(['html' => $output]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => "required",
            'class_id' => "required",
            'subjects_ids' => "required|array",
        ]);

        $teacher_id = $request->teacher_id;
        $class_id = $request->class_id;
        $all_subject_id = $request->subjects_ids;


        foreach ($all_subject_id as $subject_id) {
            assignTeacherToClass::updateOrCreate(
                // প্রথম প্যারামিটার: কোন কোন শর্তের ভিত্তিতে রেকর্ড খুঁজতে হবে
                [
                    'class_id' => $class_id, // নির্দিষ্ট ক্লাস আইডি
                    'subject_id' => $subject_id, // নির্দিষ্ট সাবজেক্ট আইডি
                    'teacher_id' => $teacher_id
                ],
                // দ্বিতীয় প্যারামিটার: খুঁজে পেলে কী কী আপডেট হবে, না পেলে নতুন রেকর্ডের জন্য কী মান থাকবে
                [
                    'class_id' => $class_id, // ক্লাস আইডি
                    'subject_id' => $subject_id, // সাবজেক্ট আইডি
                    'teacher_id' => $teacher_id
                ]

            );
        };


        return redirect()->back()->with('success', 'successfully insert subject in class');
    }

    /**
     * Display the specified resource.
     */
    public function show(assignTeacherToClass $assignTeacherToClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(assignTeacherToClass $assignTeacherToClass, $id)
    {
        $data['assignTeacherToClass'] = assignTeacherToClass::with(['academicClasses', 'subjects', 'teacher'])->find($id);

        $data['academicClass'] = academicClass::latest()->get();
        $data['teachers'] = User::where('role', 'teacher')->latest()->get();
        $data['subjects'] = subject::latest()->get();

        $cls_id = $data['assignTeacherToClass']->class_id;
        $data['assaignSubjectToClass'] = assignSubjectToClass::with('subjects')->where('class_id',  $cls_id)->get();

        return view('admin.assignTeacherToClass.assignTeacherToClass-edit', $data);
    }

    // AJAX for edit
    public function fetchSubjectsEdit(Request $request)
    {
        $classId = $request->class_id;

        $assignSubjectToClass = assignSubjectToClass::where('class_id', $classId)
            ->with(['subjects', 'academicClasses'])
            ->get();

        $assignTeacherToClass = assignTeacherToClass::find($classId);

        $outputtt = '';

        // Starting HTML for the select box
        $outputtt .= '<div class="form-group col-md-12">
                <label for="exampleInputSubject">Subject3</label>
                <select name="subject_id" id="exampleInputSubject" class="form-control">
                    <option disabled>Select subject</option>';

        // Looping through the subjects
        foreach ($assignSubjectToClass as $assignSubjectToCla) {
            $outputtt .= '<option value="' . $assignSubjectToCla->subjects->id . '"';

            // Checking if the subject is selected
            // if ($assignSubjectToCla->subject_id == $assignTeacherToClass->subject_id) {
            //     $outputtt .= ' selected';
            // }else{
            //     null;
            // }

            // Closing the option tag with the subject's name
            $outputtt .= '>' . $assignSubjectToCla->subjects->name . '</option>';
        }

        // Closing the select and div tag
        $outputtt .= '</select></div>';

        // Returning the output as JSON
        return response()->json(['html' => $outputtt]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, assignTeacherToClass $assignTeacherToClass, $id)
    {

        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
        ]);


        $data = assignTeacherToClass::find($id);
        $data->teacher_id = $request->teacher_id;
        $data->class_id = $request->class_id;
        $data->subject_id = $request->subject_id;
        $data->update();
        return redirect()->route('assignTeacherToClass.index')->with('success', 'successfully update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(assignTeacherToClass $assignTeacherToClass, $id)
    {
        assignTeacherToClass::find($id)->delete();
        return redirect()->back()->with('success', 'successfully delete');
    }
}
