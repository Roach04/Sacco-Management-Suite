<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InstallmentController extends Controller
{
    
    /**
    ** Constructor.
    **/

    //declare protected variables.
    protected $currenttime;
    protected $today;
    protected $trash;
    protected $users;
    protected $members;
    protected $trashMember;

    protected $loan;
    protected $todday;
    protected $dueDate;
    protected $lanna;
    protected $maturity;
    protected $defaulters;
    protected $daysMove;
    protected $minuDays;

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
        $this->members     = Auth::user()->members()->orderBy('created_at', 'desc')->get();

        //get all the trashed members
        $this->trashMember = Member::onlyTrashed()->get();


        /* loans. */
        $this->loan = Loan::where('state', '=', 1);

        //check the status of the loan application.
        $this->loan = $this->loan->sum('loan');
        /* loans. */

        /* loan time check */ 
        $grace   = Loan::where('state', '=', 1)->pluck('gracePeriod');

        //get when the loan was created.
        $create  = Loan::where('state', '=', 1)->pluck('created_at');

        $this->dueDate = $create->addDays($grace)->formatlocalized('%a %d %b %y');

        $this->todday  = Carbon::now()->formatlocalized('%a %d %b %y');

        //check if the due date for loan reimbursements has been realized.
        if ($this->todday >= $this->dueDate) {
            
            //we need access to this loan's member.
            $this->lanna = Loan::all();

            //get the summations of all the mature loans.
            $this->maturity = $this->lanna->sum('totalInstallments');
        }
        /* loan time check */

        /* Defaulters time check */
        $duration = Loan::where('state', '=', 1)->pluck('loanDuration');

        //get when the loan was created.
        $creatte  = Loan::where('state', '=', 1)->pluck('created_at');

        //get how many days have passed since the loan was processed.
        $this->daysMove = $creatte->addDays($duration)->diffInDays();

        //get the days to be subtracting from.
        $this->minuDays = $duration - 5;

        //check validity.
        if ($this->daysMove == $this->minuDays) {

            //this means this is the last day to pay the installments.
            
            //we need access to this loan's member.
            $this->lanna = Loan::all();
        }
        else if($this->daysMove < $this->minuDays) {

            //this means that this member has defaulted in paying the installments.

            //we need access to this loan's member.
            $this->defaulters = Loan::all();
        }
        /* Defaulters time check */

        

        //share the above throughout the views.
        //use key value pairs.
        View::share('currenttime', $this->currenttime);
        View::share('today', $this->today);
        View::share('trash', $this->trash);
        View::share('users', $this->users);
        View::share('members', $this->members);
        View::share('trashMember', $this->trashMember);

        View::share('loan', $this->loan);
        View::share('todday', $this->todday);
        View::share('dueDate', $this->dueDate);
        View::share('lanna', $this->lanna);
        View::share('maturity', $this->maturity);
        View::share('defaulters', $this->defaulters);
        View::share('daysMove', $this->daysMove);
        View::share('minuDays', $this->minuDays);   
    }


    /**
    ** Prologue
    **/
    public function index()
    {
        //
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
