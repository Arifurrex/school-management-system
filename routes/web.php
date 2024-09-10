<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix'=>'admin'],function(){
    Route::group(['middleware'=>'admin.guest'],function(){
        Route::get('login',[AdminController::class,'index'])->name('admin.login');
        Route::get('register',[AdminController::class,'register'])->name('admin.register');
        Route::post('authenticate',[AdminController::class,'authenticate'])->name('admin.authenticate');
        
    });
    Route::group(['middleware'=>'admin.auth'],function(){
        Route::get('logout',[AdminController::class,'logout'])->name('admin.logout');
        Route::get('dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
        Route::get('form',[AdminController::class,'form'])->name('admin.form');
        Route::get('table',[AdminController::class,'table'])->name('admin.table');
        Route::get('academic-year/create',[AcademicYearController::class,'index'])->name('academic-year/create');
    });  
});


