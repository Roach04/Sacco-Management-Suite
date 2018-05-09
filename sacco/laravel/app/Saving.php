<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    //protect the table.
    protected $table = 'savings';

    //get the fillables.
    protected $fillable = ['credit', 'debit', 'details', 'accounts', 'bank', 'action'];

    //relationships.
    public function user(){

    	return $this->belongsTo('App\User');
    }
}
