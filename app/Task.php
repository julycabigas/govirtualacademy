<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
    	'course_identifiers_id','name','description'
    ];


    public function group() {
        return $this->belongsTo('App\CourseGroupIdentifier', 'group_id');
    }

}
