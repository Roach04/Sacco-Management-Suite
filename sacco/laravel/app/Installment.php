<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    //table
    protected $table = 'installments';

    //fillable
    protected $fillable = ['installment', 'bank', 'monthsLeft'];

    /**
    ** Relatioships.
    **/

    //installments.
    public function member() {

        return $this->belongsTo('App\Member');
    }

    //loans
    public function loan() {

    	return $this->belongsTo('App\Loan');
    }
}
