<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    //table.
    protected $table = 'expenses';

    //fillable.
    protected $fillable = [ 'accounts' ];

    //relationships.
    public function saving() {

    	return $this->belongsTo('App\Saving');
    }
}
