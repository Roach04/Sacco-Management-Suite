<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disbursement extends Model
{
    //table
    protected $table = 'disbursements';

    //fillables.
    protected $fillable = [ 

    	'disburseMoney', 'chequeNumber', 'firstname', 'lastname', 'accountNumber', 'bank', 'loanDuration', 
        'gracePeriod', 'status'
    ];


    /**
    ** Relationships.
    **/

    //relation with loan model.
    public function loan() {

    	return $this->belongsTo('App\Loan');
    }
}
