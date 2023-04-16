<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
    	'user_id', 'content', 'approve', 'course_id', 'name', 'image'
    ];

    public function user() {
    	return $this->belongsTo('App\User');
    }
}
