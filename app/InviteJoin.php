<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InviteJoin extends Model
{
    protected $fillable = [
        'class_id', 'teacher_id', 'student_id', 'state',
    ];
}
