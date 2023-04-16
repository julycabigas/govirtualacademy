<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExerciseEntry extends Model
{
    protected $fillable = [
    	'content','comment', 'has_passed', 'exercise_id', 'user_id'
    ];

    protected $table = 'exercise_entries';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function exercise()
    {
        return $this->belongsTo('App\Exercise');
    }
}
