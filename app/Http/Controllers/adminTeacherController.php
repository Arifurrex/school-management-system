<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class adminTeacherController extends Controller
{
    public function index()
    {
        return view('adminTeacher.login');
    }


    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);


        if (Auth::guard('teacher')->attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::guard('teacher')->user()->role != 'teacher') {
                return redirect()->route('adminTeacher.logout')->with('error', 'Unauthorize user');
            } else {
                return redirect()->route('adminTeacher.dashboard');
            }
        } else {
            return redirect()->route('adminTeacher.login')->with('error', 'something went wrong');
        }
    }


    public function dashboard()
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

        return view('adminTeacher.dashboard', $data);
    }

    public function logout()
    {
        Auth::guard('teacher')->logout();
        return redirect()->route('adminTeacher.login')->with('success', 'successfully logout');
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

        return view('adminTeacher.passwordReset', $data);
    }

    public function passwordResetStore(Request $request)
    {

        $request->validate([
            'oldPass' => 'required',
            'newPass' => 'required',
            'confirmPass' => 'required|same:newPass',
        ]);

        $oldPass = $request->oldPass;
        $newPass = $request->newPass;
        $confirmPass = $request->confirmPass;

        if (Hash::check($oldPass, Auth::guard('teacher')->user()->password)) {
            Auth::guard('teacher')->user()->password = $confirmPass;
            Auth::guard('teacher')->user()->update();
            Auth::guard('teacher')->logout();

            return redirect()->route('adminTeacher.login')->with('success', 'successfully update your password');
        } else {
            return redirect()->back()->with('error', 'incorrect old password');
        }
    }
}
