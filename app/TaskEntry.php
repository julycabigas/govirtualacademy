<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskEntry extends Model
{
    protected $fillable = [
    	'task_id','screenshot','user_id', 'status', 'content'
    ];

    protected $table = 'task_entries';


    public function tasks()
    {
        return $this->belongsTo('App\Task', 'task_id');
    }
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
