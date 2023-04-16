<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    protected $fillable = [
    	'name','description','image_url', 'host', 'date', 'time', 'video'
    ];
}
