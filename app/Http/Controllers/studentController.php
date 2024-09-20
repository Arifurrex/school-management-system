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
    public function index()
    {

        $data['classes'] = academicClass::all();
        $data['FeeHeads'] = FeeHead::all();
        $data['AcademicYears'] = AcademicYear::all();

        return view('admin.student.index', $data);
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
}
