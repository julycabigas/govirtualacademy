<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    protected $fillable = [
    	'question','choice_1','choice_2','choice_3','choice_4','answer','course_id'
    ];


    public function course() {
    	return $this->belongsTo('App\Course','course_id', 'id');
    }
}
