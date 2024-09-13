<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\FeeHeadController;
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

        //academic-year-route
        Route::get('academic-year/index',[AcademicYearController::class,'index'])->name('academic-year.index');
        Route::get('academic-year/create',[AcademicYearController::class,'create'])->name('academic-year.create');
        Route::post('academic-year/store',[AcademicYearController::class,'store'])->name('academic-year.store');
        Route::get('academic-year/edit/{id}',[AcademicYearController::class,'edit'])->name('academic-year.edit');
        Route::post('academic-year/update/{id}',[AcademicYearController::class,'update'])->name('academic-year.update');
        Route::get('academic-year/delete/{id}',[AcademicYearController::class,'delete'])->name('academic-year.delete');

         //class-route
         Route::get('class/index',[ClassesController::class,'index'])->name('class.index');
         Route::get('class/create',[ClassesController::class,'create'])->name('class.create');
         Route::post('class/store',[ClassesController::class,'store'])->name('class.store');
         Route::get('class/edit/{id}',[ClassesController::class,'edit'])->name('class.edit');
         Route::post('class/update/{id}',[ClassesController::class,'update'])->name('class.update');
         Route::get('class/delete/{id}',[ClassesController::class,'delete'])->name('class.delete');

          //fee-Head-route
        Route::get('FeeHead/index',[FeeHeadController::class,'index'])->name('FeeHead.index');
        Route::get('FeeHead/create',[FeeHeadController::class,'create'])->name('FeeHead.create');
        Route::post('FeeHead/store',[FeeHeadController::class,'store'])->name('FeeHead.store');
        Route::get('FeeHead/edit/{id}',[FeeHeadController::class,'edit'])->name('FeeHead.edit');
        Route::post('FeeHead/update/{id}',[FeeHeadController::class,'update'])->name('FeeHead.update');
        Route::get('FeeHead/delete/{id}',[FeeHeadController::class,'delete'])->name('FeeHead.delete');
        
    });  
});


