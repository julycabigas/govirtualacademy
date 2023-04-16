<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
    	'menu_order','status', 'name', 'group_id'
    ];

    protected $table = 'course_modules';

    public function group()
    {
        return $this->belongsTo('App\CourseIdentifier', 'group_id');
    }
}
