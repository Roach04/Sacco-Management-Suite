<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    //table
    protected $table = 'journals';

    //fillable.
    protected $fillable = ['details', 'accountName', 'actualFigure', 'overpay', 'bank', 'duration'];

    //relationships.

    //relation with users.
    public function users() {

    	return $this->belongsTo('App\User');
    }
}
