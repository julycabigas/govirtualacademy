<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blueprint extends Model
{
    protected $fillable = [
    	'title','video','description', 'image', 'solution', 'category_id'
    ];


    public function category() {
        return $this->belongsTo('App\BlueprintCategory', 'category_id');
    }
}
