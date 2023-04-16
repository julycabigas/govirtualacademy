<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
    	'user_id', 'course_id', 'score', 'info', 'has_passed', 'has_resolve'
    ];
}
