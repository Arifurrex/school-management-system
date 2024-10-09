<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class timeTable extends Model
{
    use HasFactory;

    protected $fillable=[
        'day_id',
        'class_id',
        'subject_id',
        'start_time',
        'end_time',
        'room_no',
    ];

    public function academicClasses(){
        return $this->belongsTo(academicClass::class,'class_id');
    }


    public function subjects(){
        return $this->belongsTo(subject::class,'subject_id');
    }

    public function day(){
        return $this->belongsTo(day::class,'day_id');
    }

}
