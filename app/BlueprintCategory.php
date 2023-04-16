<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlueprintCategory extends Model
{
    protected $fillable = [
    	'name'
    ];
    protected $table = 'blueprint_categories';


    public function blueprint() {
        return $this->hasMany('App\Blueprint', 'category_id');
    }

}
