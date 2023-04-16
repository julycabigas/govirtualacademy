<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
    	'name','description','category_id'
    ];

    public function category() {
        return $this->belongsTo('App\ResourceCategory', 'category_id');
    }
}
