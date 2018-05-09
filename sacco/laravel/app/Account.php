<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    //get the table.
    protected $table = 'accounts';

    //get the fillable.
    protected $fillable = [ 'bank', 'money' ];


    //Relationships.
    public function member(){

    	return $this->belongsTo('App\Member');
    }
}
