<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'result_id', 'emailed', 'user_id', 'course_id' 
    ];

    public function result() 
    {
        return $this->hasOne('App\Result', 'id', 'result_id');
    }

    public function user() 
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function course() 
    {
        return $this->hasOne('App\Course', 'id', 'course_id');
    }
}
