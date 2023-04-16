<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BadgeRequirement extends Model
{
    protected $fillable = [
    	'badge_id','group_identifiers_id'
    ];

    protected $table = 'badge_requirements';
}
