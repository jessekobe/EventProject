<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = [
		'table', 'item_name', 'item_number', 'price', 'waiter', 'image', 'status', 'info', 'owner_id'
	];

    public function owner()
    {
    	return $this->belongsTo('App\User', 'owner_id');
    }
}
