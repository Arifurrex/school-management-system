<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assignTeacherToClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'class_id',
        'subject_id',
    ];

    public function subjects() {
        return $this->belongsTo(subject::class,'subject_id');
    }

    public function academicClasses(){
        return $this->belongsTo(academicClass::class,'class_id');
    }

    public function teacher(){
        return $this->belongsTo(User::class,'teacher_id');
    }
}
