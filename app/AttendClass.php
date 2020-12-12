<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendClass extends Model
{
    protected $fillable = [
        'class_id', 'student_id', 'teacher_id',
    ];
}
