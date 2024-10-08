<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\assignTeacherToClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class adminStudentController extends Controller
{
    public function index()
    {
        return view('adminStudent.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->role != 'student') {
                Auth::logout();
                return redirect()->route('adminStudent.login')->with('error', 'Unauthorise user ');
            } else {
                return redirect()->route('adminStudent.dashboard');
            }
        } else {
            return redirect()->route('adminStudent.login')->with('error', 'something went wrong');
        };
    }

    public function dashboard()
    {
        $data['announcement'] = Announcement::where('type', 'student')->latest()->get();

        // ছাত্রদের জন্য ডাটা গণনা
        $data['studentCount'] = \App\Models\Announcement::where('type', 'student')->count();

        // শিক্ষকদের জন্য ডাটা গণনা
        $data['teacherCount'] = \App\Models\Announcement::where('type', 'teacher')->count();

        // মোট ডাটা গণনা
        $data['totalCount'] = \App\Models\Announcement::count();

        // সকল আনরিড মেসেজ পাবেন
        $data['unreadAnnouncements'] = Announcement::where('status', 1)->get();

        // সকল রিড মেসেজ পাবেন
        $data['readAnnouncements'] = Announcement::where('status', 0)->get();

        return view('adminStudent.dashboard', $data);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('adminStudent.login')->with('success', 'successfully logout ');
    }

    public function passwordReset()
    {
        $data['announcement'] = Announcement::where('type', 'teacher')->latest()->get();

        // ছাত্রদের জন্য ডাটা গণনা
        $data['studentCount'] = \App\Models\Announcement::where('type', 'student')->count();

        // শিক্ষকদের জন্য ডাটা গণনা
        $data['teacherCount'] = \App\Models\Announcement::where('type', 'teacher')->count();

        // মোট ডাটা গণনা
        $data['totalCount'] = \App\Models\Announcement::count();

        // সকল আনরিড মেসেজ পাবেন
        $data['unreadAnnouncements'] = Announcement::where('status', 1)->get();

        // সকল রিড মেসেজ পাবেন
        $data['readAnnouncements'] = Announcement::where('status', 0)->get();

        return view('adminStudent.passwordReset', $data);
    }


    public function passwordResetStore(Request $request)
    {
        $request->validate([
            'newPass' => 'required',
            'confirmPass' => 'required|same:newPass',
        ]);

        $oldPass = $request->oldPass;
        $newPass = $request->newPass;
        $confirmPass = $request->confirmPass;

        if (Hash::check($oldPass, Auth::user()->password)) {
            Auth::user()->password = $confirmPass;
            Auth::user()->update();
            Auth::logout();

            return redirect()->route('adminStudent.login')->with('success', 'successfully update your password');
        } else {
            return redirect()->back()->with('error', 'Your old password wrong');
        }
    }



    // teacher own subject and class
    public function  studentOwnClassAndSubject()
    {
        $studentClassId = Auth::guard('web')->user()->academic_class_id;
        $data['information'] = assignTeacherToClass::where('class_id',  $studentClassId)->with(['academicClasses', 'subjects'])->get();

        $data['announcement'] = Announcement::where('type', 'teacher')->latest()->get();

        // ছাত্রদের জন্য ডাটা গণনা
        $data['studentCount'] = \App\Models\Announcement::where('type', 'student')->count();

        // শিক্ষকদের জন্য ডাটা গণনা
        $data['teacherCount'] = \App\Models\Announcement::where('type', 'teacher')->count();

        // মোট ডাটা গণনা
        $data['totalCount'] = \App\Models\Announcement::count();

        // সকল আনরিড মেসেজ পাবেন
        $data['unreadAnnouncements'] = Announcement::where('status', 1)->get();

        // সকল রিড মেসেজ পাবেন
        $data['readAnnouncements'] = Announcement::where('status', 0)->get();

        return view('adminStudent.studentOwnClassAndSubject', $data);
    }
}
