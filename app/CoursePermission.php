<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoursePermission extends Model
{
    protected $table = 'course_permissions';


    protected $fillable = [
    	'course_id', 'role_id'
    ];
}
