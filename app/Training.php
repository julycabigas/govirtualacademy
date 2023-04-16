<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
    	'access_id','course_id',
    ];


    public $timestamps = false;

    public function course() {
    	return $this->hasOne('App\Course', 'id', 'course_id');
    }

    public function access() {
    	return $this->hasOne('App\AccessLevel');
    }
}
