<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillable = [
    	'name','description'
    ];

    public function requirements()
    {
        return $this->hasMany('App\BadgeRequirement');
    }
    public function studentsBadge()
    {
        return $this->hasMany('App\StudentBadges');
    }

}
