<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	protected $fillable = [
		'name', 'message', 'info', 'owner_id'
	];

    public function owner()
    {
    	return $this->belongsTo('App\User', 'owner_id');
    }
}
