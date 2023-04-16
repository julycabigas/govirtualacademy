<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreeTrial extends Model
{
    protected $fillable = [
    	'step_limit','user_id', 'group_id'
    ];

    protected $table = 'free_trials';
}
