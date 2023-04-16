<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessLevel extends Model
{
    protected $fillable = [
    	'name','display_name', 'short_description', 'reg_price', 'discount_price', 'type'
    ];

    protected $table = 'access_levels';

    public $timestamps = false;
}
