<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessItem extends Model
{
    protected $fillable = [
    	'user_id','access_id',
    ];

    protected $table = 'access_items';
}
