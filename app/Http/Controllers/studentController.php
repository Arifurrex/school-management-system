<?php

namespace App\Http\Controllers;

use App\Models\academicClass;
use App\Models\AcademicYear;
use App\Models\FeeHead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class studentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['academicClass', 'academicYear'])->where('role', 'student')->latest('id');
        if ($request->filled('academic_class_id')) {
            $query->where('academic_class_id', $request->get('academic_class_id'));
        };
        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->get('academic_year_id'));
        };
        $students = $query->get();
        $data['student'] =  $students;
        $data['classes'] = academicClass::all();
        $data['FeeHeads'] = FeeHead::all();
        $data['AcademicYears'] = AcademicYear::all();
        
        return view ('admin.student.student-list', $data);
    }


    public function create()
    {

        $data['classes'] = academicClass::all();
        $data['FeeHeads'] = FeeHead::all();
        $data['AcademicYears'] = AcademicYear::all();

        return view('admin.student.student', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'academic_class_id' => 'required',
            'academic_year_id' => 'required',
            'admission_date' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'dob' => 'required',
            'mobile_no' => 'required',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->academic_class_id = $request->academic_class_id;
        $user->academic_year_id = $request->academic_year_id;
        $user->admission_date = $request->admission_date;
        $user->name = $request->name;
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->dob = $request->dob;
        $user->mobile_no = $request->mobile_no;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'student';
        $user->save();
        return redirect()->route('student.create')->with('success', 'successfully added student');
    }

    public function edit($id)
    {
        $data['student'] = User::find($id);
        $data['classes'] = academicClass::all();
        $data['FeeHeads'] = FeeHead::all();
        $data['AcademicYears'] = AcademicYear::all();
        return view('admin.student.student-edit', $data);
    }

    public function update(Request $request, $id)
    {
        $data = User::find($id);
        $data->name = $request->name;
        $data->email  = $request->email;
        $data->academic_class_id = $request->academic_class_id;
        $data->academic_year_id  = $request->academic_year_id;
        $data->admission_date = $request->admission_date;
        $data->father_name = $request->father_name;
        $data->mother_name = $request->mother_name;
        $data->dob = $request->dob;
        $data->mobile_no = $request->mobile_no;
        $data->update();
        return redirect()->route('student.index')->with('success', 'successfully update');
    }

    public function delete($id)
    {
        $data = User::find($id);
        $data->delete();
        return redirect()->route('student.index')->with('success', 'successfully delete');
    }
}
