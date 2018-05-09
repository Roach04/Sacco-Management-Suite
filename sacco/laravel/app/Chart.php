<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    //table.
    protected $table = 'charts';

    //fillables.
    protected $fillable = [ 'accountName', 'category', 'description', 'money', 'detail'];

    /**
    **	Relationships.
    **/

    //relationship with the user.
    public function user() {

    	return $this->belongsTo('App\User');
    }

    //relationship with sub charts.
    public function subcharts() {

        return $this->hasMany('App\Subchart');
    }
}
