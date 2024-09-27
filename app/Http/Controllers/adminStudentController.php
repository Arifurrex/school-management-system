<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
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
        $teacherCount = \App\Models\Announcement::where('type', 'teacher')->count();

        // মোট ডাটা গণনা
        $totalCount = \App\Models\Announcement::count();

        return view('adminStudent.dashboard', $data);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('adminStudent.login')->with('success', 'successfully logout ');
    }

    public function passwordReset()
    {
        return view('adminStudent.passwordReset');
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
}
