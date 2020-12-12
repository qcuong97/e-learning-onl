<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'class_code', 'room', 'class_name', 'subject', 'class_image', 'creator_id',
    ];
}
