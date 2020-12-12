<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $fillable = [
        'class_id', 'description', 'source',
    ];
}
