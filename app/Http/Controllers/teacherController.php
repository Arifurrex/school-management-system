<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\academicClass;
use App\Models\AcademicYear;
use App\Models\FeeHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class teacherController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['academicClass', 'academicYear'])->where('role', 'teacher')->latest('id');
        if ($request->filled('academic_class_id')) {
            $query->where('academic_class_id', $request->get('academic_class_id'));
        };
        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->get('academic_year_id'));
        };
        $teachers = $query->get();
        $data['teacher'] =  $teachers;
        $data['classes'] = academicClass::all();
        $data['FeeHeads'] = FeeHead::all();
        $data['AcademicYears'] = AcademicYear::all();

        return view('admin.teacher.teacher-list', $data);
    }


    public function create()
    {
        return view('admin.teacher.teacher');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'dob' => 'required',
            'mobile_no' => 'required',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->name = $request->name;
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->dob = $request->dob;
        $user->mobile_no = $request->mobile_no;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'teacher';
        $user->save();
        return redirect()->route('teacher.create')->with('success', 'successfully added teacher');
    }

    public function edit($id)
    {
        $data['teacher'] = User::find($id);
        return view('admin.teacher.teacher-edit', $data);
    }

    public function update(Request $request, $id)
    {
        $data = User::find($id);
        $data->name = $request->name;
        $data->email  = $request->email;
        $data->father_name = $request->father_name;
        $data->mother_name = $request->mother_name;
        $data->dob = $request->dob;
        $data->mobile_no = $request->mobile_no;
        $data->update();
        return redirect()->route('teacher.index')->with('success', 'successfully update');
    }

    public function delete($id)
    {
        $data = User::find($id);
        $data->delete();
        return redirect()->route('teacher.index')->with('success', 'successfully delete');
    }
}
