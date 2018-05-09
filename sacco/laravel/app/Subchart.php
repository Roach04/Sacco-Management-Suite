<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subchart extends Model
{
    //table.
    protected $table = 'subcharts';

    //fillables.
    protected $fillable = [ 'subAccountName', 'category', 'description', 'money', 'detail' ];

    /**
    **	Relationships.
    **/
    public function chart() {

    	return $this->belongsTo('App\Chart');
    }
}
