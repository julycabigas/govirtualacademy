<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
    	'title','description','group_id'
    ];

    public function entry()
    {
        return $this->hasMany('App\ExerciseEntry');
    }
}
