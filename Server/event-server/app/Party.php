<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = [
         'name', 'date', 'description', 'info', 'people_number', 'money_spent', 'profit'
    ];
}
