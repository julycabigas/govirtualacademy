<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportCategory extends Model
{
    protected $fillable = [
    	'name'
    ];
    protected $table = 'support_categories';

    public function support() {
        return $this->hasMany('App\Support', 'category_id');
    }
}
