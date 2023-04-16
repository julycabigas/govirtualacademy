<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{
    protected $fillable = [
    	'name'
    ];

    protected $table = 'resource_categories';

    public function resource() {
        return $this->hasMany('App\Resource', 'category_id');
    }
}
