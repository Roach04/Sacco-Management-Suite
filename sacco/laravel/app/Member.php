<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

	use SoftDeletes;

	//create a field name called deleted_at and assign a varibale to the same.
	protected $dates = ['deleted_at'];

	//create a function and pass in a variable date to it.
    public function setDuedateAttribute($date){

        //changing the string that was passed in as today to an actual date.
        $this->attributes['today'] = Carbon::parse($date);
    }

    //get the table.
    protected $table = 'members';

    //get the fillable.
    protected $fillable = [

    	'accountNumber', 'loanStatus', 'guaranteeStatus', 'totals', 'guaranteeMoney', 'firstname', 'surname', 
        'lastname', 'maritalStatus', 'occupation', 'gender', 'bankName', 'bankAccountName', 'bankAccountNumber', 
        'phoneNumber', 'idNumber', 'dateOfBirth', 'emailAddress', 'poBox', 'county', 'nationality', 
        'accountType', 'memberPic', 'slug',
    	'firstnameKin', 'surnameKin', 'lastnameKin', 'maritalStatusKin', 'occupationKin', 'genderKin',
        'phoneNumberKin', 'idNumberKin', 'dateOfBirthKin', 'relationshipKin', 'emailAddressKin', 'poBoxKin', 
        'countyKin', 'nationalityKin'
    ];


    /**
    ** Relationships.
    **/
    public function user(){

    	return $this->belongsTo('App\User');
    }

    //accounts.
    public function account(){

        return $this->hasMany('App\Account');
    }

    //installments.
    public function installments(){

        return $this->hasMany('App\Installment');
    }

    //loan.
    public function loan(){

        return $this->hasMany('App\Loan');
    }
}
