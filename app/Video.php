<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
    	'title', 'description', 'file', 'course_id', 'time', 'menu_order'
    ];


    public function course() 
    {
    	return $this->hasOne('App\Course', 'id', 'course_id');
    }
}
