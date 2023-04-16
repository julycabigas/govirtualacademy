<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'short_description', 'description','orig_price','discount_price', 'course_identifier_id', 'inclusions','learn','requirement', 'category_id','status', 'featured', 'image', 'passing_score','timer','total_students', 'rating'
    ];

    public function video() 
    {
    	return $this->hasMany('App\Video', 'course_id', 'id');
    }

    public function category() 
    {
        return $this->hasOne('App\Category', 'category_id', 'id');
    }

    public function exam()
    {
        return $this->hasMany('App\Examination', 'course_id', 'id');
    }

}
