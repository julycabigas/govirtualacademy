<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseGroupIdentifier extends Model
{
    protected $fillable = [
    	'menu_order','course_identifiers_id','course_id', 'status', 'module_id'
    ];

    protected $table = 'course_group_identifiers';


    public function identifier() {
        return $this->belongsTo('App\CourseIdentifier', 'course_identifiers_id');
    }

    public function module() {
        return $this->belongsTo('App\Module', 'module_id');
    }

    public function course() {
        return $this->belongsTo('App\Course', 'course_id');
    }

    
}
