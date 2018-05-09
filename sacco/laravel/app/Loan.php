<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    //get the table.
    protected $table = 'loans';

    //fillables.
    protected $fillable = [
    
        'loan', 'modeOfPayment', 'loanEntity', 'loanType', 'monthlyInstallment', 'totalInstallments', 
        'guaranteeOne', 'guaranteeTwo', 'guaranteeThree', 'moneyOne', 'moneyTwo', 'moneyThree', 'loanDuration'
    ];

    /**
    ** Relatioships.
    **/

    //members.
    public function member() {

    	return $this->belongsTo('App\Member');
    }

    //installments
    public function installments() {

    	return $this->hasMany('App\Installment');
    }

    //disbursement.
    public function disbursements() {

        return $this->hasMany('App\Disbursement');
    }
}
