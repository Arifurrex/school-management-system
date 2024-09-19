<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class feeStructure extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'academic_year_id',
        'fee_head_id',
        'academic_class_id',
        'january',
        'february',
        'march',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december',
    ];

    // ১. Mass Assignment কী?
// Mass Assignment হলো Laravel-এ একটি ফিচার, যা আপনাকে একসাথে অনেকগুলো ইনপুট ফিল্ডের মান ডাটাবেসে ইনসার্ট বা আপডেট করতে দেয়। উদাহরণস্বরূপ, আপনি যদি কোনো ফর্ম থেকে একাধিক ইনপুট ফিল্ডের ডাটা ডাটাবেসে একসাথে পাঠাতে চান, তখন আপনি একসাথে অনেকগুলো ফিল্ডকে ডাটাবেসে ইনসার্ট করতে পারেন।

// উদাহরণ:
// $feeStructure = FeeStructure::create($request->all());

// এখানে $request->all() এর মাধ্যমে ইনপুট ফিল্ডের সব ডাটাগুলো একসাথে ইনসার্ট করা হবে। এটি Mass Assignment।


    public function academicClass(){
       return $this->belongsTo(academicClass::class);
    }

    public function FeeHead(){
        return $this->belongsTo(FeeHead::class);
    }

    public function AcademicYear(){
        return $this->belongsTo(AcademicYear::class);
    }
}
