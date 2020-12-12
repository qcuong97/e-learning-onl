<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestJoin extends Model
{
    protected $fillable = [
        'class_id', 'student_id', 'state',
    ];
}
