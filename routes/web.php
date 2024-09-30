<?php

use App\Http\Controllers\AcademicClassController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\adminStudentController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AssignSubjectToClassController;
use App\Http\Controllers\FeeHeadController;
use App\Http\Controllers\FeeStructureController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\SubjectController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// route for student user
Route::group(['prefix' => 'adminStudent'], function () {
    //guest .. Laravel এর guest middleware এই উদ্দেশ্যে তৈরি করা হয়েছে যে, যারা ইতিমধ্যে লগইন করেছে তারা যেন লগইন পেজ বা রেজিস্ট্রেশন পেজে যেতে না পারে। অর্থাৎ, লগইন করা ইউজার যদি লগইন পেজে যেতে চায়, তাকে সরাসরি ড্যাশবোর্ডে রিডাইরেক্ট করা উচিত।
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [adminStudentController::class, 'index'])->name('adminStudent.login');
        Route::post('authenticate', [adminStudentController::class, 'authenticate'])->name('adminStudent.authenticate');
    });
    //auth
    Route::group(['middleware' => 'auth'], function () {

        Route::get('dashboard', [adminStudentController::class, 'dashboard'])->name('adminStudent.dashboard');
        Route::get('logout', [adminStudentController::class, 'logout'])->name('adminStudent.logout');
        Route::get('password-reset', [adminStudentController::class, 'passwordReset'])->name('adminStudent.passwordReset');
        Route::post('password-reset/store', [adminStudentController::class, 'passwordResetStore'])->name('adminStudent.passwordReset.store');

        // announcemnet read and undread
        // read and unread
        Route::post('mark-as-read', [AnnouncementController::class, 'markAsRead']);
    });
});


// route for admin user
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('login', [AdminController::class, 'index'])->name('admin.login');
        Route::get('register', [AdminController::class, 'register'])->name('admin.register');
        Route::post('authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('form', [AdminController::class, 'form'])->name('admin.form');
        Route::get('table', [AdminController::class, 'table'])->name('admin.table');

        //academic-year-route
        Route::get('academic-year/index', [AcademicYearController::class, 'index'])->name('academic-year.index');
        Route::get('academic-year/create', [AcademicYearController::class, 'create'])->name('academic-year.create');
        Route::post('academic-year/store', [AcademicYearController::class, 'store'])->name('academic-year.store');
        Route::get('academic-year/edit/{id}', [AcademicYearController::class, 'edit'])->name('academic-year.edit');
        Route::post('academic-year/update/{id}', [AcademicYearController::class, 'update'])->name('academic-year.update');
        Route::get('academic-year/delete/{id}', [AcademicYearController::class, 'delete'])->name('academic-year.delete');

        //class-route
        Route::get('class/index', [AcademicClassController::class, 'index'])->name('class.index');
        Route::get('class/create', [AcademicClassController::class, 'create'])->name('class.create');
        Route::post('class/store', [AcademicClassController::class, 'store'])->name('class.store');
        Route::get('class/edit/{id}', [AcademicClassController::class, 'edit'])->name('class.edit');
        Route::post('class/update/{id}', [AcademicClassController::class, 'update'])->name('class.update');
        Route::get('class/delete/{id}', [AcademicClassController::class, 'delete'])->name('class.delete');

        //fee-Head-route
        Route::get('FeeHead/index', [FeeHeadController::class, 'index'])->name('FeeHead.index');
        Route::get('FeeHead/create', [FeeHeadController::class, 'create'])->name('FeeHead.create');
        Route::post('FeeHead/store', [FeeHeadController::class, 'store'])->name('FeeHead.store');
        Route::get('FeeHead/edit/{id}', [FeeHeadController::class, 'edit'])->name('FeeHead.edit');
        Route::post('FeeHead/update/{id}', [FeeHeadController::class, 'update'])->name('FeeHead.update');
        Route::get('FeeHead/delete/{id}', [FeeHeadController::class, 'delete'])->name('FeeHead.delete');

        //feeStructure-route
        Route::get('FeeStructure/index', [FeeStructureController::class, 'index'])->name('FeeStructure.index');
        Route::get('FeeStructure/create', [FeeStructureController::class, 'create'])->name('FeeStructure.create');
        Route::post('FeeStructure/store', [FeeStructureController::class, 'store'])->name('FeeStructure.store');
        Route::get('FeeStructure/edit/{id}', [FeeStructureController::class, 'edit'])->name('FeeStructure.edit');
        Route::post('FeeStructure/update/{id}', [FeeStructureController::class, 'update'])->name('FeeStructure.update');
        Route::get('FeeStructure/delete/{id}', [FeeStructureController::class, 'delete'])->name('FeeStructure.delete');


        //student-route
        Route::get('student/index', [studentController::class, 'index'])->name('student.index');
        Route::get('student/create', [studentController::class, 'create'])->name('student.create');
        Route::post('student/store', [studentController::class, 'store'])->name('student.store');
        Route::get('student/edit/{id}', [studentController::class, 'edit'])->name('student.edit');
        Route::post('student/update/{id}', [studentController::class, 'update'])->name('student.update');
        Route::get('student/delete/{id}', [studentController::class, 'delete'])->name('student.delete');


        //announcement-route
        Route::get('announcement/index', [AnnouncementController::class, 'index'])->name('announcement.index');
        Route::get('announcement/create', [AnnouncementController::class, 'create'])->name('announcement.create');
        Route::post('announcement/store', [AnnouncementController::class, 'store'])->name('announcement.store');
        Route::get('announcement/edit/{id}', [AnnouncementController::class, 'edit'])->name('announcement.edit');
        Route::post('announcement/update/{id}', [AnnouncementController::class, 'update'])->name('announcement.update');
        Route::get('announcement/delete/{id}', [AnnouncementController::class, 'delete'])->name('announcement.delete');


        //subject management
        Route::get('subject/index', [SubjectController::class, 'index'])->name('subject.index');
        Route::get('subject/create', [SubjectController::class, 'create'])->name('subject.create');
        Route::post('subject/store', [SubjectController::class, 'store'])->name('subject.store');
        Route::get('subject/edit/{id}', [SubjectController::class, 'edit'])->name('subject.edit');
        Route::post('subject/update/{id}', [SubjectController::class, 'update'])->name('subject.update');
        Route::get('subject/delete/{id}', [SubjectController::class, 'delete'])->name('subject.delete');


        //assign subject to class
        Route::get('assignSubjectToClass/index', [AssignSubjectToClassController::class, 'index'])->name('assignSubjectToClass.index');
        Route::get('assignSubjectToClass/create', [AssignSubjectToClassController::class, 'create'])->name('assignSubjectToClass.create');
        Route::post('assignSubjectToClass/store', [AssignSubjectToClassController::class, 'store'])->name('assignSubjectToClass.store');
        Route::get('assignSubjectToClass/edit/{id}', [AssignSubjectToClassController::class, 'edit'])->name('assignSubjectToClass.edit');
        Route::post('assignSubjectToClass/update/{id}', [AssignSubjectToClassController::class, 'update'])->name('assignSubjectToClass.update');
        Route::get('assignSubjectToClass/delete/{id}', [AssignSubjectToClassController::class, 'delete'])->name('assignSubjectToClass.delete');
    });
});
