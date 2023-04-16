<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentBadges extends Model
{
    protected $fillable = [
    	'badge_id','total_star'
    ];

    protected $table = 'student_badges';


    public function badges()
    {
        return $this->belongsTo('App\Badge', 'badge_id');
    }
    public function users()
    {
        return $this->belongsTo('App\User', 'student_id');
    }
}
