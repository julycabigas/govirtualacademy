<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseIdentifier extends Model
{
    protected $fillable = [
    	'name','course_id','level','access_id', 'image', 'description'
    ];

    protected $table = 'course_identifiers';

    
}
