<?php

namespace App;

use Project\setDuedateAttribute;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    //protect the deleted_at field name as soft deletes.
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    //create a function and pass in a variable date to it.
    public function setDuedateAttribute($date){

        //changing the string that was passed in as today to an actual date.
        $this->attributes['today'] = Carbon::parse($date);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname','lastname','phoneNumber','idNumber', 'jobTitle', 'userPic', 'emailAddress',
        'username', 'password', 'today', 'active', 'role', 'code', 'slug'];
   


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    /**
    ** Relationships.
    **/
    public function members(){

        return $this->hasMany('App\Member');
    }

    //Relationship with the savings table.
    public function savings(){

        return $this->hasMany('App\Saving');
    }

    //relationship with the charts table.
    public function charts() {

        return $this->hasMany('App\Chart');
    }

    //relationship with journals table.
    public function journals() {

        return $this->hasMany('App\Journal');
    }
}
