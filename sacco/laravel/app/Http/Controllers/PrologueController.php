<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Member;
use App\Saving;
use App\Account;
use DB;
use Auth;
use View;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class PrologueController extends Controller
{
    /**
    ** Constructor.
    **/

    //declare protected variables.
    protected $currenttime;
    protected $today;
    protected $trash;
    protected $users;
    protected $trashMember;
    protected $members;

    //create the constructor.
    public function __construct(){

        //pass the items to the view.

        //get the current time.
        $this->currenttime = Carbon::now('Africa/Nairobi')->format('h:i a');

        //get todays time.
        $this->today       = Carbon::now()->formatlocalized('%a %d %b %y');

        //get all the trashed users
        $this->trash       = User::onlyTrashed()->get();

        //get all the users.
        $this->users       = User::all();

        //get all the members.
        $this->members       = Member::all();

        //get all the trashed members
        $this->trashMember = Member::onlyTrashed()->get();

        //share the above throughout the views.
        //use key value pairs.
        View::share('currenttime', $this->currenttime);
        View::share('today', $this->today);
        View::share('trash', $this->trash);
        View::share('users', $this->users);
        View::share('trashMember', $this->trashMember);
        View::share('members', $this->members);
    }


    /**
    ** Prologue
    **/
    public function index()
    {
        //title
        $title = 'Prologue.';

        /* sacco savings. */
        $savings = Saving::all();

        $credit = $savings->sum('credit');

        $debit  = $savings->sum('debit');

        $sacco  = $credit - $debit;
        /* sacco savings. */

        /* member totals. */
        $accounts = Account::all();

        $money = $accounts->sum('money');
        /* member totals. */

        return View('auth.prologue', compact('sacco', 'money'))
            ->with('title', $title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
