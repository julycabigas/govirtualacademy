<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{

	protected $fillable = [
    	'user_id', 'amount', 'status', 'payment_method', 'training', 'access_id', 'notes'
    ];

    public function user() {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

	public function access() {
    	return $this->hasOne('App\AccessLevel', 'id', 'access_id');
    }
}
