<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Member;
use App\Saving;
use App\Account;
use App\Loan;
use App\Installment;
use App\Expense;
use DB;
use Auth;
use View;
use Carbon\Carbon;
use PDF;
use App;
use App\Chart;
use App\Subchart;
use App\Disbursement;
use App\Journal;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
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
    protected $loans;
    protected $trashMember;

    protected $loan;
    protected $todday;
    protected $dueDate;
    protected $lanna;
    
    protected $installmentLeft;
    protected $installmentMinus;

    protected $maturedLoan;
    protected $maturity;
    protected $defaultLoan;

    protected $loanStatus;
    protected $guaranteeStatus;

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
        $this->loans       = Loan::where('state', '=', 1)->get();
        /* loans. */

        /* loans. */
        $this->loan = Loan::where('state', '=', 2);
        /* loans. */

        /* loans. */
        $this->maturedLoan = Loan::where('state', '=', 2)->get();
        /* loans. */

        /* loans. */
        $this->defaultLoan = Loan::where('state', '=', 3)->get();
        /* loans. */

        //check the status of the loan application.
        $this->loan = $this->loan->sum('loan');
        /* loans. */

        /* Update when the last day of loan reimbursements arrives. */
        
        //get the last sacco day of loan repayments.
        $lastDay = Carbon::now()->endOfMonth()->subDays(13);

        //estimate a time period when a member has already defaulted.
        $estimate = Carbon::now()->endOfMonth()->subDays(13)->addDays(4);

        //get today.
        $today = Carbon::now();

        //get all the loans.
        $loans = Loan::where('state', '=', 2)->get();    

        //get all members with matured loans
        $this->loanStatus = Member::where('loanStatus', '=', 1)->get();

        //get all members who are guarantors.
        $this->guaranteeStatus = Member::where('guaranteeStatus', '=', 1)->get();

        /* Get the total installments paid via matured loans. */
        $this->maturity = $this->maturedLoan->sum('totalInstallments');
        /* Get the total installments paid via matured loans. */


        //share the above throughout the views.
        //use key value pairs.
        View::share('currenttime', $this->currenttime);
        View::share('today', $this->today);
        View::share('trash', $this->trash);
        View::share('users', $this->users);
        View::share('members', $this->members);
        View::share('trashMember', $this->trashMember);
        View::share('loans', $this->loans);

        View::share('loan', $this->loan);
        View::share('todday', $this->todday);
        View::share('dueDate', $this->dueDate);
        View::share('lanna', $this->lanna);

        View::share('installmentLeft', $this->installmentLeft);
        View::share('installmentMinus', $this->installmentMinus);


        View::share('maturedLoan', $this->maturedLoan);
        View::share('maturity', $this->maturity);
        View::share('defaultLoan', $this->defaultLoan);

        View::share('loanStatus', $this->loanStatus);
        View::share('guaranteeStatus', $this->guaranteeStatus); 
    }

    /**
     * Dashboard
     */
    public function dashboard()
    {
        $title = 'Dashboard.';

        /* sacco savings. */
        $savings = Saving::all();

        $credit = $savings->sum('credit');

        $debit  = $savings->sum('debit');

        $sacco  = $credit - $debit;
        /* sacco savings. */

        /* account totals. */
        $account = Account::all();

        $money   = $account->sum('money');
        /* member totals. */

        //get the summations of debits and credits.
        $sumdebit   = DB::table('savings')->where('action', '=', 'debit')->sum('debit');

        $sumcredit  = DB::table('savings')->where('action', '=', 'credit')->sum('credit');

        /* Debits */
        $debits  = Saving::where('accounts', '!=', 'Nill')
                ->orderBy('debit', 'desc')->take(5)
                ->get();
        /* Debits */

        /* Guarantors */
        $guarantors = Member::where('guaranteeStatus', '=', 1)
                ->orderBy('guarantorMoney', 'desc')->take(4)
                ->get();
        /* Guarantors */

        /* Member and Account */
        $accounts = Member::where('totals', '>', 0)->take(4)
                ->orderBy('totals', 'desc')->get();
        /* Member and Account */

        /* Loan and Member */
        $loanMember = Loan::where('state', '=', 2)->with(['member' => function ($query) {

            $query->orderBy('created_at', 'desc');

        }])->get();
        /* Member and Loan */  

        $loanz = Loan::where('state', '>=', 1)->get();

        $today = Carbon::now();

        $installs = Installment::all();

        /*foreach($loans as $loan) {

            foreach($installs as $install) {

                //installment creation.  14th
                $lastCreation = $install->latest()->pluck('created_at');

                //get today.
                $today = Carbon::now();

                //go back 30 days.
                $backThirty = $today->subDays(15)->endOfDay(); //13th

                $leo = Carbon::now();

                if ($lastCreation > $backThirty && $lastCreation < $leo) {
            
                    //First Default ... this member has paid the installment.
                    $data = [

                        'state' => 3
                    ];

                    //update the db.
                    $loan->update($data);
                }
                else {

                    //First Default ... this member has paid the installment.
                    $data = [

                        'state' => 2
                    ];

                    //update the db.
                    $loan->update($data);
                }
            }
        }*/

        //Loans disbursed.
        $disbursed = Disbursement::sum('disburseMoney');

        return View('auth.dashboard', compact( 'disbursed', 'loanz', 'sumdebit', 'sumcredit', 'sacco', 'money', 'savings', 'debits', 'guarantors', 'loanMember', 'accounts'))
        ->with('title', $title);    
           
    }

    /**
     * Charts
     */
    public function charts()
    {
        $title = 'Charts.';

        return View('auth.charts', compact('trash', 'today', 'currenttime'))
            ->with('title', $title);
    }

    /**
     * Forms
     */
    public function forms()
    {
        $title = 'Forms.';

        return View('auth.forms')
            ->with('title', $title);
    }

    /**
     * System Accounts.
     */
    public function sysAccounts()
    {

        $title = 'System Accounts.';

        return View('auth.accounts')
            ->with('title', $title);
    }

    /**
     * Assign roles to system users.
     */
    public function assignRoles($id)
    {
        //access all users.
        $user = User::find($id);

        $title = 'Assign Roles.';

        return View('auth.roles', ['user' => $user])
            ->with('title', $title);
    }

    /**
    ** Store a newly created resource in storage.
    **/
    public function storeRoles(Request $request)
    {
        //validate the roles field.
        $this->validate($request, [
            'body' => 'required',
            'id'   => 'required',
            ]);

        //then find the user by id.
        $user = User::find($request['id']);

        //access the roles in our users table.
        $user->role = $request['body'];

        //update the table.
        $user->update();

        return response()->json(['result' => $user->role, 'userId' => $user->id, 'feedback' => 'User\'s Role Updated Successfully.' ], 200);
    }

    /**
    ** Trash users
    **/
    public function trash($id) {

        //get use by id
        $user = User::find($id);

        //get the names of the user.
        $fname = $user->firstname;
        $lname = $user->lastname;

        $user->delete();

        //re direct accordingly.
        return redirect()->back()
            -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-warning alert-dismissible" role="alert">' . $fname .' '. $lname. ' ' .'Trashed Succefully.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
   }

    /**
    ** Trashed accounts
    **/
    public function trashed() {

        $title = 'Trashed Users.';
        
        //re direct accordingly.
        return View('auth.trashed')
            ->with('title', $title);
            
   }

    /**
    ** Restore Trashed accounts
    **/
    public function restoreAll() {

        //get the the trashed users and restore them.
        User::onlyTrashed()->restore();
        
        //re direct accordingly.
        return redirect()->route('sysAccounts')
            -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-success alert-dismissible" role="alert"> Users Restored Succefully. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
            
   }

   /**
    ** Restore a single Trashed account.
    **/
    public function restore($id) {

       //restore a single trashed user.
        $project = User::whereId($id)
                ->onlyTrashed()->restore();

        //get the entire record based on the provided id.
        $data = User::find($id);

        //get the firstname.
        $fname = $data->firstname;

        //get the lastname.
        $lname = $data->lastname;

        //get trashed members.
        $trash = User::onlyTrashed()->get();

        //get all the trashed members.
        if (count($trash)>0) {
            
            //re direct accordingly.
            return redirect()->back()
                -> with('global', '<p style="font:bold 20px book antiqua; width:100%; padding:30px; margin-top:-20px; text-align:center" class="alert alert-info alert-dismissible" role="alert">' . $fname . ' '. $lname .' Restored Succefully.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
        }
        else{

            //re direct accordingly.
            return redirect()->route('sysAccounts')
                -> with('global', '<p style="font:bold 20px book antiqua; width:100%; padding:30px; margin-top:-20px; text-align:center" class="alert alert-info alert-dismissible" role="alert">' . $fname . ' '. $lname .' Restored Succefully.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
        }         
   }

    /**
    ** Sacco Savings.
    **/
    public function savings(Request $request)
    {
        //validation.
        $this->validate($request, [

            /*'credit'   => 'boolean',
            'debit'    => 'boolean',*/
            'details'  => 'required',
            'account'  => 'required',
            'bank'     => 'required'
        ]);

        if ($request->fails) {
            
            return redirect()->route('createCashbook')
                ->withErrors($request)
                ->withInput();
        }
        else {

            $credit   = $request->credit;

            $debit    = $request->debit;

            $details  = $request->details;

            $account  = $request->account;

            $bank     = $request->bank;

            //check the debit column in our db in its totality and sum it up.
            $sumcredit = Auth::user()->savings()->sum('credit');

            //sum up all the debit from our db.
            $sumdebit  = Auth::user()->savings()->sum('debit');

            //ensure that your accounts are balanced.
            if ($sumdebit == $sumcredit) {
                
                //ensure that what was provided by the user is either a credit or a debit.
                //an expense is a debit balance therefore equity bank
                if ($debit) {

                    //get the data into an array.
                    $save = Auth::user()->savings()->create([

                        'credit'   => $debit,
                        'debit'    => $debit,
                        'details'  => $details,
                        'accounts' => $account,
                        'bank'     => $bank,
                        'action'   => 'debit',
                    ]);

                    if ($save) {
                        
                        $chart    = Chart::where('accountName', '=', $account)->first();

                        $subchart = DB::table('subcharts')->where('subAccountName', '=', $account)->first();

                        //get the cash which should be zero.
                        $cash = $debit - $debit;

                        if ($chart) {

                            if($bank == 'Equity Bank') {

                                //get the money.
                                $total = $chart->money;

                                //do a summation to the existing money which should be zero.
                                $summation = $total + $cash;

                                //also we need to increment the details with the money going out
                                DB::table('charts')->where('accountName', '=', $account)->increment('detail', $debit);

                                $data = [

                                    'money' => $summation
                                ];

                                //update charts table with the data.
                                DB::table('charts')->where('accountName', '=', $account)->update($data);

                                //we also need to update the correct bank account
                                //since its debit ==> this is money out.
                                $equityBank = Chart::where('accountName', '=', 'Equity Bank')->pluck('money');

                                //increase its value by the debit.
                                $shisha = $equityBank - $debit;

                                $data = [

                                    'money' => $shisha
                                ];

                                //update charts table with the data.
                                DB::table('charts')->where('accountName', '=', 'Equity Bank')->update($data);
                            }
                            else if ($bank == 'Petty Cash') {
                                
                                //get the money.
                                $total = $chart->money;

                                //do a summation to the existing money.
                                $summation = $total + $cash;

                                $data = [

                                    'money' => $summation
                                ];

                                //also we need to increment the details with the money coming in
                                DB::table('charts')->where('accountName', '=', $account)->increment('detail', $debit);

                                //update charts table with the data.
                                DB::table('charts')->where('accountName', '=', $account)->update($data);

                                //we also need to update the correct bank account
                                //since its debit ==> this is money out.
                                $pettyCash = Chart::where('accountName', '=', 'Petty Cash')->pluck('money');

                                //decrease its value by the debit.
                                $shisha = $pettyCash - $debit;

                                $data = [

                                    'money' => $shisha
                                ];

                                //update charts table with the data.
                                DB::table('charts')->where('accountName', '=', 'Petty Cash')->update($data);
                            }
                        }
                        else if ($subchart) {
                            
                            if($bank == 'Equity Bank') {

                                //get the money.
                                $total = $subchart->money;

                                //do a summation to the existing money.
                                $summation = $total + $cash;
                                
                                $data = [

                                    'money' => $summation
                                ];

                                //also we need to increment the details with the money coming in
                                DB::table('subcharts')->where('accountName', '=', $account)->increment('detail', $debit);

                                //update charts table with the data.
                                DB::table('subcharts')->where('subAccountName', '=', $account)->update($data);

                                //we also need to update the correct bank account
                                //since its debit ==> this is money out.
                                $equityBank = Chart::where('accountName', '=', 'Equity Bank')->pluck('money');

                                //increase its value by the debit.
                                $shisha = $equityBank - $debit;

                                $data = [

                                    'money' => $shisha
                                ];

                                //update charts table with the data.
                                DB::table('charts')->where('accountName', '=', 'Equity Bank')->update($data);
                            }
                            else if ($bank == 'Petty Cash') {
                                
                                //get the money.
                                $total = $subchart->money;

                                //do a summation to the existing money.
                                $summation = $total + $cash;
                                
                                $data = [

                                    'money' => $summation
                                ];

                                //also we need to increment the details with the money coming in
                                DB::table('subcharts')->where('accountName', '=', $account)->increment('detail', $debit);

                                //update charts table with the data.
                                DB::table('subcharts')->where('subAccountName', '=', $account)->update($data);

                                //we also need to update the correct bank account
                                //since its debit ==> this is money out.
                                $pettyCash = Chart::where('accountName', '=', 'Petty Cash')->pluck('money');

                                //increase its value by the debit.
                                $shisha = $pettyCash - $debit;

                                $data = [

                                    'money' => $shisha
                                ];

                                //update charts table with the data.
                                DB::table('charts')->where('accountName', '=', 'Petty Cash')->update($data);
                            }
                        }

                        return redirect()->route('createCashbook')
                        ->with('global', '<p style="font:20px book antiqua; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-info alert-dismissible" role="alert">' . 'Sacco Savings Recorded Successfully.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
                    }
                    else{

                        return redirect()->route('createCashbook')
                        ->with('global', '<p style="font:20px book antiqua; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-danger alert-dismissible" role="alert">' . 'Sacco Savings NOT Recorded.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
                    }
                }
                elseif ($credit) {

                    //this is a credit balance meaning coop bank
                    //get the data into an array.
                    $save = Auth::user()->savings()->create([

                        'credit'   => $credit,
                        'debit'    => $credit,
                        'details'  => $details,
                        'accounts' => $account,
                        'bank'     => $bank,
                        'action'   => 'credit',
                    ]);
                    if ($save) {
                        
                        $chart    = Chart::where('accountName', '=', $account)->first();

                        $subchart = DB::table('subcharts')->where('subAccountName', '=', $account)->first();

                        //get the cash which should be zero.
                        $cash = $credit - $credit;

                        if ($chart) {
                           
                            //get the money.
                            $total = $chart->money;

                            //do a summation to the existing money.
                            $summation = $total + $cash;

                            $data = [

                                'money' => $summation
                            ];

                            //also we need to increment the details with the money coming in
                            DB::table('charts')->where('accountName', '=', $account)->increment('detail', $credit);

                            //update charts table with the data.
                            DB::table('charts')->where('accountName', '=', $account)->update($data);

                            //we also need to update the correct bank account
                            //since its credit ==> this is money out.
                            $coopBank = Chart::where('accountName', '=', 'Co-op Bank')->pluck('money');

                            //decrease its value by the credit.
                            $shisha = $coopBank + $credit;

                            $data = [

                                'money' => $shisha
                            ];

                            //update charts table with the data.
                            DB::table('charts')->where('accountName', '=', 'Co-op Bank')->update($data);                            
                        }
                        else if ($subchart) {
                            
                            //get the money.
                            $total = $subchart->money;

                            //do a summation to the existing money.
                            $summation = $total + $cash;

                            $data = [

                                'money' => $summation
                            ];

                            //also we need to increment the details with the money coming in
                            DB::table('subcharts')->where('accountName', '=', $account)->increment('detail', $credit);

                            //update charts table with the data.
                            DB::table('subcharts')->where('subAccountName', '=', $account)->update($data);

                            //we also need to update the correct bank account
                            //since its credit ==> this is money out.
                            $equityBank = Chart::where('accountName', '=', 'Co-op Bank')->pluck('money');

                            //decrease its value by the credit.
                            $shisha = $equityBank + $credit;

                            $data = [

                                'money' => $shisha
                            ];

                            //update charts table with the data.
                            DB::table('charts')->where('accountName', '=', 'Co-op Bank')->update($data);
                        }

                        return redirect()->route('createCashbook')
                        ->with('global', '<p style="font:20px book antiqua; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-info alert-dismissible" role="alert">' . 'Sacco Savings Recorded Successfully.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
                    }
                    else{

                        return redirect()->route('createCashbook')
                        ->with('global', '<p style="font:20px book antiqua; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-danger alert-dismissible" role="alert">' . 'Sacco Savings NOT Recorded.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
                    }                
                }
            }
            else {

               //cancel the transaction.
                return redirect()->route('createCashbook')
                ->with('global', '<p style="font:20px book antiqua; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-danger alert-dismissible" role="alert">' . 'Sacco\'s Accounts Are NOT Balanced.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
            }                                 
        }       
    }

    /**
    ** Show Sacco savings.
    **/
    public function show($id)
    {
        $title = 'Savings.';

        //get the savings via id.
        $savings = Auth::user()->savings()->orderBy('created_at', 'desc')->paginate(10);

        //we need to show equity bank's cash.
        $equityBank = Chart::where('accountName', '=', 'Equity Bank')->pluck('money');

        //equity bank's opening balance.
        $equityopeningbalance = Chart::where('accountName', '=', 'Equity Opening Balance')->pluck('money');

        //we need to show coop bank's cash.
        $coopBank = Chart::where('accountName', '=', 'Co-op Bank')->pluck('money');

        //coop bank's opening balance.
        $coopopeningbalance = Chart::where('accountName', '=', 'Co-op Opening Balance')->pluck('money');

        //we need to show petty cash
        $pettycash  = Chart::where('accountName', '=', 'Petty Cash')->pluck('money');

        //petty cash's opening balance.
        $pettycashopeningbalance = Chart::where('accountName', '=', 'Petty Cash Opening Balance')->pluck('money');

        //get the aggregate of the two bank accounts.
        $cash = $equityBank + $pettycash;

        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');

            return View('auth.showSavings', compact('coopBank', 'coopopeningbalance', 'equityopeningbalance', 'pettycashopeningbalance', 'equityBank', 'pettycash', 'savings', 'cash', 'last', 'sumcredit', 'sumdebit'))
                ->with('title', $title);
        }
        else {

            return View('auth.showSavings', compact('savings', 'cash', 'sumcredit', 'sumdebit'))
                ->with('title', $title);
        }        
    }

    /**
    ** Update Sacco Savings 
    **/
    public function updates(Request $request)
    {
        //validation.
        $this->validate($request, [
            'credit'  => 'required',
            'debit'   => 'required',
            'account' => 'required'
            ]);

        if ($request->fails) {
            
            return response()->json([ 'failed' => 'Sacco Savings Updates Failed.' ]);
        }
        else {

            $id     = $request['id'];

            $credit = $request['credit'];

            $debit  = $request['debit'];

            $account = $request['account'];

            //check the debit column in our db in its totality and sum it up.
            $sumcredit = Auth::user()->savings()->sum('credit');

            //sum up all the debit from our db.
            $sumdebit  = Auth::user()->savings()->sum('debit');

            if($sumcredit > $sumdebit) {

                //then find the savings by id.
                $check = DB::table('savings')->where('id', $id)->first();

                //check if the data has been changed.
                $currentcredit  = $check->credit;

                $currentdebit   = $check->debit;

                $currentaccount = $check->accounts;

                if ($currentcredit == $credit && $currentdebit == $debit && $currentaccount == $account) {
                    
                    //cancel the transaction.
                    return response()->json(['failure' => 'Your Account hasn\'t Changed' ], 200);
                }
                else if ($debit && $sumcredit <= $sumdebit) {
                    
                    //cancel the transaction.
                    return response()->json(['failure' => 'Your Account Will Be Negative' ], 200);
                }
                else if($credit || $account) {

                    //then find the savings by id.
                    $saver = Saving::where('id', '=', $id);

                    //access the field names to be updated from our table.
                    $data = [

                        'credit'   => $credit,

                        'debit'    => $debit,

                        'accounts' => $account
                    ];

                    //update the table.
                    $saver->update($data);

                    if ($saver) {
                        
                        return response()->json(['response' => 'Sacco Account Updated Successfully' ], 200);
                    }
                    else{

                        return response()->json(['failure' => 'Sacco Account Updates Failed.' ], 200);
                    }
                } 
                else {

                    return response()->json(['failure' => 'Your Updates Will Negate This Account' ], 200);
                }
            } 
            else if($sumcredit == $sumdebit) {               

                //then find the savings by id.
                $check = DB::table('savings')->where('id', $id)->first();

                //check if the data has been changed.
                $currentcredit = $check->credit;

                $currentdebit  = $check->debit;

                $currentaccount = $check->accounts;

                if ($currentcredit == $credit && $currentdebit == $debit && $currentaccount == $account) {
                    
                    //cancel the transaction.
                    return response()->json(['failure' => 'Your Account hasn\'t Changed' ], 200);
                }
                else if($debit > $currentdebit) {

                    return response()->json(['failure' => 'Your Account is NILL'], 200);
                }    
                else if($credit < $debit) {

                    //then find the savings by id.
                    $saver = Saving::where('id', '=', $id);

                    //access the field names to be updated from our table.
                    $data = [

                        'credit' => $credit,

                        'debit'  => $debit,

                        'accounts' => $account,
                    ];

                    //update the table.
                    $saver->update($data);

                    if ($saver) {
                        
                        return response()->json(['response' => 'Sacco Account Updated Successfully' ], 200);
                    }
                    else{

                        return response()->json(['failure' => 'Sacco Account Updates Failed.' ], 200);
                    }
                }            
                else if($credit && $debit <= $currentdebit) {

                    //then find the savings by id.
                    $saver = Saving::where('id', '=', $id);

                    //access the field names to be updated from our table.
                    $data = [

                        'credit' => $credit,

                        'debit'  => $debit,

                        'accounts' => $account,
                    ];

                    //update the table.
                    $saver->update($data);

                    if ($saver) {
                        
                        return response()->json(['response' => 'Sacco Account Updated Successfully' ], 200);
                    }
                    else{

                        return response()->json(['failure' => 'Sacco Account Updates Failed.' ], 200);
                    }
                }  
            } 
            else if ($sumcredit < $sumdebit) {
                
                //cancel the transaction.
                return response()->json(['failure' => 'Your Account is Negative' ], 200);
            }         
                        
            return response()->json(['failure' => 'Your Account is Empty'], 200);
            
        }
    }

    /**
    ** coop Bank Reconciliation 
    **/
    public function coopReconcile() {

        $title = 'Coop Bank Reconciliation.';

        //get the savings via id.
        $savings = Auth::user()->savings()->where('bank', '=', 'Co-op Bank')->orderBy('created_at', 'desc')->paginate(50);

        //get all members that have made deposits via co-op bank.
        $depositsCoop = Account::where('bank', '=', 'Co-op Bank')->with('member')->get();

        //get all members that have made loan payments via loan=>installments under co-op bank.
        $memberLoanCoopPayments = Installment::where('bank', '=', 'Co-op Bank')->with('loan')->get();

        //get all disbursements concerning coop bank
        $loancoopdisbursements = Disbursement::where('bank', '=', 'Co-op Bank')->with('loan')->get();
        
        //get the chart of accounts.
        $charts = Chart::with('subcharts')->get();

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Saving::where('bank', '=', $coop)->sum('debit');

        //get equity's opening balance.
        $coopopeningbalance = Chart::where('accountName', '=', 'Co-op Opening Balance')->pluck('money');

        //get all monies deposited to coop by sacco members.
        $coopDeposit = Account::where('bank', '=', 'Co-op Bank')->sum('money');

        //loan reimbursements via coop
        $coopReimburse = Installment::where('bank', '=', 'Co-op Bank')->sum('installment');

        //loan disbursements via coop
        $coopDisburse = Disbursement::where('bank', '=', 'Co-op Bank')->sum('disburseMoney');

        //get coop aggregate.
        $coopAggregate = ($coopopeningbalance + $coopDeposit + $coopReimburse + $coopAccount) - $coopDisburse;

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.coopReconcile', compact('coopDeposit', 'coopReimburse', 'coopDisburse', 'coopAggregate', 'coopopeningbalance', 'loancoopdisbursements', 'memberLoanCoopPayments', 'depositsCoop', 'coopAccount', 'equityAccount', 'charts', 'savings', 'last', 'sumcredit', 'sumdebit', 'cash'))
                ->with('title', $title);
        }
        else {

            return View('auth.coopReconcile', compact('savings'))
            ->with('title', $title);
        }
    }

    /**
    ** March coop Reconciliation
    **/
    public function reconcileCoopMarch() {

        $title = 'Co - op Bank March.';

        //get the current year.
        $year = Carbon::now()->year;        

        //get the savings via id.
        $savings = Auth::user()->savings()->where('bank', '=', 'Co-op Bank')->whereBetween('created_at', [ '2018-03-01', '2018-03-31' ])->orderBy('created_at', 'desc')->paginate(10);

        //get all members that have made deposits via co-op bank.
        $depositsCoop = Account::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->with('member')->orderBy('created_at', 'desc')->get();

        //get all disbursements concerning coop bank
        $loancoopdisbursements = Disbursement::where('bank', '=', 'Co-op Bank')->with('loan')->orderBy('created_at', 'desc')->get();

        //get all members that have made loan payments via loan=>installments under co-op bank.
        $memberLoanCoopPayments = Installment::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->with('loan')->orderBy('created_at', 'desc')->get();

        //get equity bank.
        $eq     = 'Equity Bank';

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Saving::where('bank', '=', $coop)->sum('debit');

        //get the opening balance for coop bank
        $coopopeningbalance = Chart::where('accountName', '=', 'Co-op Opening Balance')->pluck('money');

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = $coopAccount = Saving::where('bank', '=', $coop)->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('debit');

        //we need to equally produce monies deposited by members via equity account.
        $coopDeposit = Account::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $coopReimburse = Installment::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('installment');

        //coop disbursements made
        $coopDisburse = Disbursement::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('disburseMoney');

        //then get the coop account's aggregate.
        $coopAggregate = ($coopopeningbalance + $coopAccount + $coopDeposit + $coopReimburse) - $coopDisburse;

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.reconcileCoopMarch', compact('coopopeningbalance', 'equityopeningbalance', 'coopAggregate', 'coopAccount', 'coopDeposit', 'coopDisburse', 'coopReimburse', 'depositsCoop', 'memberLoanCoopPayments', 'loancoopdisbursements', 'equityAccount', 'coopAccount', 'savings', 'last'))
                ->with('title', $title);
        }
        else {

            return View('auth.reconcileCoopMarch', compact('savings'))
            ->with('title', $title);
        }
    }

    /**
    ** April coop Reconciliation
    **/
    public function reconcileCoopApril() {

        $title = 'Co - op Bank April.';

        //get the current year.
        $year = Carbon::now()->year;        

        //get the savings via id.
        $savings = Auth::user()->savings()->where('bank', '=', 'Co-op Bank')->whereBetween('created_at', [ '2018-04-01', '2018-04-30' ])->orderBy('created_at', 'desc')->paginate(10);

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Saving::where('bank', '=', $coop)->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->sum('credit');

        //get all members that have made deposits via co-op bank.
        $depositsCoop = Account::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->with('member')->orderBy('created_at', 'desc')->get();

        //get all disbursements concerning coop bank
        $loancoopdisbursements = Disbursement::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->with('loan')->orderBy('created_at', 'desc')->get();

        //get all members that have made loan payments via loan=>installments under co-op bank.
        $memberLoanCoopPayments = Installment::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->with('loan')->orderBy('created_at', 'desc')->get();

        //we need to equally produce monies deposited by members via equity account.
        $coopDeposit = Account::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $coopLoan    = Installment::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->sum('installment');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $coopReimburse = Installment::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->sum('installment');

        //coop disbursements made
        $coopDisburse = Disbursement::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->sum('disburseMoney');


        //get equity's march opening balance.
        $coopopeningbalanceMarch = Chart::where('accountName', '=', 'Co-op Opening Balance')->pluck('money');

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $coopAccountMarch  = Saving::where('bank', '=', $coop)->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('debit');

        //we need to equally produce monies deposited by members via equity account.
        $coopDepositMarch  = Account::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $coopDisburseMarch = Disbursement::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('disburseMoney');

        //coop bank responsible for loan reimbursements
        $coopReimburseMarch = Installment::where('bank', '=', 'Co-op Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('installment');
        
        //then get the coop account's aggregate.
        $equityendingbalanceMarch = ($coopopeningbalanceMarch + $coopAccountMarch + $coopDepositMarch + $coopReimburseMarch) - $coopDisburseMarch;

        //then get the coop account's aggregate.
        $coopAggregate = ($equityendingbalanceMarch + $coopAccount + $coopDeposit + $coopReimburse) - $coopDisburse;

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.reconcileCoopApril', compact('equityendingbalanceMarch', 'coopAggregate', 'coopAccount', 'coopDeposit', 'coopReimburse', 'coopDisburse', 'depositsCoop', 'memberLoanCoopPayments', 'loancoopdisbursements', 'cash', 'equityAccount', 'coopAccount', 'savings', 'last'))
                ->with('title', $title);
        }
        else {

            return View('auth.reconcileCoopApril', compact('savings'))
            ->with('title', $title);
        }
    }

    /**
    ** equity Bank Reconciliation 
    **/
    public function equityReconcile() {

        $title = 'Equity Bank Reconciliation.';

        //get the savings via id.
        $savings = Auth::user()->savings()->where('bank', '=', 'Equity Bank')->orderBy('created_at', 'desc')->paginate(50);

        //get all members that have made deposits via co-op bank.
        $depositsEquity = Account::where('bank', '=', 'Equity Bank')->with('member')->get();

        //get all members that have made loan payments via loan=>installments under co-op bank.
        $memberLoanEquityPayments = Installment::where('bank', '=', 'Equity Bank')->with('loan')->get();

        //get all disbursements concerning coop bank
        $loanequitydisbursements = Disbursement::where('bank', '=', 'Equity Bank')->with('loan')->get();
        
        //get the journal plus its data.
        $equityJournal   = Journal::where('bank', '=', 'Equity Bank')->orderBy('created_at', 'desc')->get();

        //get the chart of accounts.
        $charts = Chart::with('subcharts')->get();

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Saving::where('bank', '=', $eq)->sum('credit');

        //get equity's opening balance.
        $equityopeningbalance = Chart::where('accountName', '=', 'Equity Opening Balance')->pluck('money');

        //we need to equally produce monies deposited by members via coop account.
        $equityDeposit = Account::where('bank', '=', 'Equity Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityDisburse = Disbursement::where('bank', '=', 'Equity Bank')->sum('disburseMoney');

        //also we need to produce monies that have been paid as loan reimbursements via coop account.
        $equityReimburse = Installment::where('bank', '=', 'Equity Bank')->sum('installment');        

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->sum('overpay');

        //get the total expense.
        $equitySumJournal = $actualFigureEquity + $overpayEquity;

        //then get the coop account's aggregate.
        $equityAggregate = ($equityopeningbalance + $equityDeposit + $equityReimburse) - ($equityDisburse + $equityAccount + $equitySumJournal);

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.equityReconcile', compact('equitySumJournal', 'equityJournal', 'equityopeningbalance', 'equityDeposit', 'equityDisburse', 'equityReimburse', 'equityAggregate', 'depositsEquity', 'loanequitydisbursements', 'memberLoanEquityPayments', 'depositsCoop', 'coopAccount', 'equityAccount', 'charts', 'savings', 'last'))
                ->with('title', $title);
        }
        else {

            return View('auth.equityReconcile', compact('savings'))
            ->with('title', $title);
        }
    }

    /**
    ** March equity Reconciliation
    **/
    public function reconcileEquityMarch() {

        $title = 'Equity Bank March.';

        //get the current year.
        $year = Carbon::now()->year;        

        //get the savings via id.
        $savings = Auth::user()->savings()->where('bank', '=', 'Equity Bank')->whereBetween('created_at', [ '2018-03-01', '2018-03-31' ])->orderBy('created_at', 'desc')->paginate(30);

        //get all members that have made loan payments via loan=>installments under co-op bank.
        $memberLoanEquityPayments = Installment::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->with('loan')->get();

        //get all disbursements concerning coop bank
        $loanequitydisbursements = Disbursement::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->with('loan')->get();

        //get all members that have made deposits via co-op bank.
        $depositsEquity = Account::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->with('member')->get();

        //get the journal plus its data.
        $equityJournal   = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->orderBy('created_at', 'desc')->get();

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Saving::where('bank', '=', $eq)->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('debit');

        //we need to equally produce monies deposited by members via equity account.
        $equityDeposit = Account::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityDisburse = Disbursement::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('disburseMoney');

        //equity bank responsible for reimbursements
        $equityReimburse = Installment::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('installment');

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('overpay');

        //get the total expense.
        $equitySumJournal = $actualFigureEquity + $overpayEquity;

        //get equity's opening balance.
        $equityopeningbalance = Chart::where('accountName', '=', 'Equity Opening Balance')->pluck('money');

        //then get the coop account's aggregate.
        $equityAggregate = ($equityopeningbalance + $equityDeposit + $equityReimburse) - ($equityDisburse + $equityAccount + $equitySumJournal);

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.reconcileEquityMarch', compact('equitySumJournal', 'equityJournal', 'equityopeningbalance', 'equityDeposit', 'equityDisburse', 'equityReimburse', 'equityAggregate', 'depositsEquity', 'memberLoanEquityPayments', 'loanequitydisbursements', 'equityAccount', 'coopAccount', 'savings', 'last'))
                ->with('title', $title);
        }
        else {

            return View('auth.reconcileEquityMarch', compact('savings'))
            ->with('title', $title);
        }
    }

    /**
    ** April equity Reconciliation
    **/
    public function reconcileEquityApril() {

        $title = 'Equity Bank April.';

        //get the current year.
        $year = Carbon::now()->year;        

        //get the savings via id.
        $savings = Auth::user()->savings()->where('bank', '=', 'Equity Bank')->whereBetween('created_at', [ '2018-04-01', '2018-04-30' ])->orderBy('created_at', 'desc')->paginate(10);

        //get all members that have made deposits via co-op bank.
        $depositsEquity = Account::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->with('member')->get();

        //get all members that have made loan payments via loan=>installments under co-op bank.
        $memberLoanEquityPayments = Installment::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->with('loan')->get();

        //get all disbursements concerning coop bank
        $loanequitydisbursements = Disbursement::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->with('loan')->get();

        //get the journal plus its data.
        $equityJournal   = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->orderBy('created_at', 'desc')->get();

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Saving::where('bank', '=', $eq)->whereBetween('created_at', ['2018-04-01', '2018-04-31'])->sum('credit');

        //we need to equally produce monies deposited by members via equity account.
        $equityDeposit  = Account::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityDisburse = Disbursement::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->sum('disburseMoney');

        //equity bank responsible for reimbursements
        $equityReimburse = Installment::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->sum('installment');
        
        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-04-01', '2018-04-30'])->sum('overpay');

        //get the total expense.
        $equitySumJournalApril = $actualFigureEquity + $overpayEquity;

        //get equity's march opening balance.
        $equityopeningbalanceMarch = Chart::where('accountName', '=', 'Equity Opening Balance')->pluck('money');

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccountMarch  = Saving::where('bank', '=', $eq)->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('credit');

        //we need to equally produce monies deposited by members via equity account.
        $equityDepositMarch  = Account::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityDisburseMarch = Disbursement::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('disburseMoney');

        //equity bank responsible for reimbursements
        $equityReimburseMarch = Installment::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('installment');

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', ['2018-03-01', '2018-03-31'])->sum('overpay');

        //get the total expense.
        $equitySumJournalMarch = $actualFigureEquity + $overpayEquity;

        //then get the coop account's aggregate.
        $equityendingbalanceMarch = ($equityopeningbalanceMarch + $equityDepositMarch + $equityReimburseMarch) - ($equityDisburseMarch + $equityAccountMarch + $equitySumJournalMarch);

        //then get the coop account's aggregate.
        $equityAggregate = ($equityendingbalanceMarch + $equityDeposit + $equityReimburse) - ($equityDisburse + $equityAccount + $equitySumJournalApril);

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.reconcileEquityApril', compact('equitySumJournalApril', 'equityJournal', 'equityendingbalanceMarch', 'equityopeningbalance', 'equityDeposit', 'equityDisburse', 'equityReimburse', 'equityAggregate', 'depositsEquity', 'memberLoanEquityPayments', 'loanequitydisbursements', 'cash', 'equityAccount', 'coopAccount', 'savings', 'last'))
                ->with('title', $title);
        }
        else {

            return View('auth.reconcileEquityApril', compact('savings'))
            ->with('title', $title);
        }
    }

    /**
    ** petty cash Reconciliation 
    **/
    public function pettycashReconcile() {

        $title = 'Petty Cash Reconciliation.';

        //get the savings via id.
        $savings = Auth::user()->savings()->where('bank', '=', 'Petty Cash')->orderBy('created_at', 'desc')->paginate(50);
        
        //get the chart of accounts.
        $charts = Chart::with('subcharts')->get();

        //petty cash account
        $petty = 'Petty Cash';

        //get the monies in pettycash account
        $pettycashAccount = Chart::where('accountName', '=', $petty)->pluck('money');

        //get pettycash bank's opening balance
        $pettycashopeningbalance = Chart::where('accountName', '=', 'Petty Cash Opening Balance')->pluck('money');

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.pettyReconcile', compact('pettycashopeningbalance', 'pettycashAccount', 'coopAggregate', 'equityAggregate', 'coopAccount', 'equityAccount', 'charts', 'savings', 'last'))
                ->with('title', $title);
        }
        else {

            return View('auth.pettyReconcile', compact('savings'))
            ->with('title', $title);
        }
    }

    /**
    ** March petty cash Reconciliation
    **/
    public function reconcilePettycashMarch() {

        $title = 'Petty Cash March.';

        //get the current year.
        $year = Carbon::now()->year;        

        //get the savings via id.
        $savings = Auth::user()->savings()->where('bank', '=', 'Petty Cash')->whereBetween('created_at', [ '2018-03-01', '2018-03-31' ])->orderBy('created_at', 'desc')->paginate(10);

        //petty cash account
        $petty = 'Petty Cash';

        //get the monies in pettycash account
        $pettycashAccount = Chart::where('accountName', '=', $petty)->whereBetween('created_at', [ '2018-03-01', '2018-03-31' ])->pluck('money');

        //get pettycash bank's opening balance
        $pettycashopeningbalance = Chart::where('accountName', '=', 'Petty Cash Opening Balance')->whereBetween('created_at', [ '2018-03-01', '2018-03-31' ])->pluck('money');

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.reconcilePettycashMarch', compact('pettycashAccount', 'pettycashopeningbalance', 'savings', 'last'))
                ->with('title', $title);
        }
        else {

            return View('auth.reconcilePettycashMarch', compact('savings'))
            ->with('title', $title);
        }
    }

    /**
    ** April petty cash Reconciliation
    **/
    public function reconcilePettycashApril() {

        $title = 'Petty Cash April.';

        //get the current year.
        $year = Carbon::now()->year;        

        //get the savings via id.
        $savings = Auth::user()->savings()->where('bank', '=', 'Petty Cash')->whereBetween('created_at', [ '2018-04-01', '2018-04-30' ])->orderBy('created_at', 'desc')->paginate(10);

        //petty cash account
        $petty = 'Petty Cash';

        //get the monies in pettycash account
        $pettycashAccount = Chart::where('accountName', '=', $petty)->whereBetween('created_at', [ '2018-04-01', '2018-04-30' ])->pluck('money');

        //get pettycash bank's opening balance
        $pettycashopeningbalance = Chart::where('accountName', '=', 'Petty Cash Opening Balance')->whereBetween('created_at', [ '2018-04-01', '2018-04-30' ])->pluck('money');

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.reconcilePettycashApril', compact('pettycashAccount', 'pettycashopeningbalance', 'savings', 'last'))
                ->with('title', $title);
        }
        else {

            return View('auth.reconcilePettycashApril', compact('savings'))
            ->with('title', $title);
        }
    }

    /**
    ** Twelve Months Reconciliation
    **/
    public function twelve() {

        $title = '12 Months Reconcile.';

        //get today.
        $today = Carbon::now();

        //minus 12 months from today.
        $minusTwelve = $today->subMonth(12);

        //get the savings via id.
        $savings = Auth::user()->savings()->where('updated_at', '>=', $minusTwelve)->orderBy('created_at', 'desc')->paginate(10);

        //check the debit column in our db in its totality and sum it up.
        $sumcredit = $savings->sum('credit');

        //sum up all the debit from our db.
        $sumdebit  = $savings->sum('debit');

        // This will hold the count for you
        $cash = $sumcredit - $sumdebit;

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.reconcileTwelve', compact('savings', 'last', 'cash', 'sumcredit', 'sumdebit'))
                ->with('title', $title);
        }
        else {

            return View('auth.reconcileTwelve', compact('savings', 'sumcredit', 'sumdebit', 'cash'))
            ->with('title', $title);
        }
    }

    /**
    ** Savings data in Json.
    **/
    public function savingsJson() {

        $savings = DB::table('savings')->get();


        return response()->json(['i' => $savings]);
    }

    /**
    ** Search data in Json.
    **/
    public function searchJson(Request $request) {

        //get the search term from our input.
        $searchTerm = $request->searchText;

        //grab the data to be searched.
        $searches   = DB::table('members')->where('firstname','LIKE','%'.$searchTerm.'%')->get();

        //count the above result in order to respond appropriately.
        //autocomplete search expects an array to be returned to it.

        //declare an empty array.
        $searchResult = [];

        if (count($searches) > 0) {
            
            //use foreach to iterate thru! the results.
            foreach ($searches as $key => $value) {
                
                $searchResult[] = $value->firstname;
            }
        }
        else if($searches <= 0) {

            $searchResult[] = "This Record Doesn\'t Exist.";
        }

        return response()->json([ 'response' => $searchResult ], 200);
    }

    /**
    ** Chart of Accounts.
    **/
    public function chartAccounts() {

        $title = 'Chart of Accounts.';

        //get today.
        $today = Carbon::now();

        //get the savings via id.
        $savings = Auth::user()->savings()->orderBy('created_at', 'desc')->get();

        // This will hold the count for you
        $chartcash = Chart::where('category', '!=', 'bank')->sum('money');

        $subchartcash = Subchart::where('category', '!=', 'bank')->sum('money');

        //get the cash.
        $cash = $chartcash + $subchartcash;

        //get the opening balance of each bank.
        $coopopeningbalance   = Chart::where('accountName', '=', 'Co-op Opening Balance')->pluck('money');

        $equityopeningbalance = Chart::where('accountName', '=', 'Equity Opening Balance')->pluck('money');

        $pettycashopeningbalance = Chart::where('accountName', '=', 'Petty Cash Opening Balance')->pluck('money');

        //get the chart of accounts.
        $charts = Chart::with('subcharts')->get();

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        $equity = Saving::where('bank', '=', $eq)->get();

        //sum equitys credits.
        $equityCredit = $equity->sum('credit');

        //sum equitys debits.
        $equityDebit  = $equity->sum('debit');

        //equity's account.
        $equityAccount = $equityCredit - $equityDebit;

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        $coop = Saving::where('bank', '=', $coop)->get();

        //sum equitys credits.
        $coopCredit = $coop->sum('credit');

        //sum equitys debits.
        $coopDebit  = $coop->sum('debit');

        //equity's account.
        $coopAccount = $coopCredit - $coopDebit;

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.chartOfAccounts', compact('pettycashopeningbalance', 'coopopeningbalance', 'equityopeningbalance', 'equityAccount', 'coopAccount', 'charts', 'savings', 'last', 'sumcredit', 'sumdebit', 'cash'))
                ->with('title', $title);
        }
        else {

            return View('auth.chartOfAccounts', compact('equityAccount', 'coopAccount', 'charts', 'savings', 'sumcredit', 'sumdebit', 'cash'))
            ->with('title', $title);
        }
    }

    /**
    ** Create chart of Accounts.
    **/
    public function createChartAccounts() {

        $title = 'Create Chart of Accounts.';

        return View('auth.createChartOfAccounts')
            ->with('title', $title);
    }

    /**
    ** Store chart of Accounts.
    **/
    public function storeCharts(Request $request) {

        //validation
        $this->validate($request, [

            'accountName'    => 'required',
            'category'       => 'required',
            'description'    => 'required',
            'money'          => 'required'
            ]);

        if ($request->fails) {
            
            return redirect()->route('createChartAccounts')
                ->withInput()
                ->withErrors($request);
        }
        else {

            //get the data from the form.
            $accountName    = $request->accountName;
            $category       = $request->category;
            $description    = $request->description;
            $money          = $request->money;

            //use the relationship to insert the data above into a db.
            Auth::user()->charts()->create([

                'accountName'    => $accountName,
                'category'       => $category,
                'description'    => $description,
                'money'          => $money
            ]);

            //re route accordingly.
            return redirect()->route('chartAccounts')
                ->with('global', '<p style="font:20px book antiqua; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-info alert-dismissible" role="alert">' . 'Chart Of Accounts Created Successfully.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
        }
    }

    /**
    ** Sub Chart of Accounts.
    **/
    public function storeSubCharts(Request $request) {

        //validation.
        $this->validate($request, [

            'subAccountName' => 'required',
            'category'       => 'required',
            'description'    => 'required',
        ]);

        if ($request->fails) {
            
            return response()->json(['error' => 'Your Fields are Empty.'], 200);
        }
        else {

            //get the id.
            $id = $request->id;

            $subAccountName = $request['subAccountName'];
            $category       = $request['category'];
            $description    = $request['description'];
            $money          = $request['money'];

            //insert the data via a relationship.
            //find the chart via id.
            $chart = Chart::find($id);

            $done = $chart->subcharts()->create([

                'subAccountName' => $subAccountName,
                'category'       => $category,
                'description'    => $description,
                'money'          => $money,
            ]);            

            //ensure insertion.
            if ($done) {
                
                return response()->json([ 'response' => 'Sub Account Created Successfully.' ], 200);
            }
            else {

                return response()->json([ 'failure' => 'Sub Account Not Created At All.' ], 200);
            }
        }
    }

    /**
    ** Chart of Accounts Statement.
    **/
    public function chartStatement($id) {

        $title = 'Chart Statement';

        //find all chart via id.
        $chart = Chart::find($id);

        //gain access to the transactions with regard to the chart in qn.
        $accountName = $chart->accountName;

        $savings = Saving::where('accounts', '=', $accountName)->orderBy('created_at', 'desc')->get();

        //get the journal plus its data.
        $equityJournal   = Journal::where('accountName', '=', $accountName)->orderBy('created_at', 'desc')->get();

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->sum('overpay');

        //get the total expense.
        $equityJournalSum = $actualFigureEquity + $overpayEquity;

        return View('auth.chartStatement', compact('chart', 'savings', 'equityJournalSum', 'equityJournal'))
            ->with('title', $title);
    }

    /**
    ** Subchart of Accounts Statement.
    **/
    public function subchartStatement($id) {

        $title = 'Subchart Statement';

        //find all chart via id.
        $subchart = Subchart::find($id);

        //gain access to the transactions with regard to the chart in qn.
        $accountName = $subchart->subAccountName;

        $savings = Saving::where('accounts', '=', $accountName)->orderBy('created_at', 'desc')->get();

        return View('auth.subchartStatement', compact('subchart', 'savings'))
            ->with('title', $title);
    }

    /**
    ** Coop bank Cash book.
    **/
    public function coopCashbook() {

        $title = 'Co - op Bank Cash Book.';

        //get the savings via id.
        $savings = Auth::user()->savings()->where('bank', '=', 'Co-op Bank')->orderBy('created_at', 'desc')->get();

        //get all members that have made deposits via co-op bank.
        $depositsCoop = Account::where('bank', '=', 'Co-op Bank')->with('member')->orderBy('created_at', '=', 'desc')->get();

        //we need to get all loans that have been disbursed from equity bank
        $coopDisburse  = Disbursement::where('bank', '=', 'Coop Bank')->orderBy('created_at', '=', 'desc')->get();

        //get all members that have made loan payments via loan=>installments under co-op bank.
        $memberLoanPayments = Installment::where('bank', '=', 'Co-op Bank')->with('loan')->orderBy('created_at', '=', 'desc')->get();
        
        //get the journal plus its data.
        $equityJournal      = Journal::where('bank', '=', 'Equity Bank')->orderBy('created_at', 'desc')->get();

        //get the chart of accounts.
        $charts = Chart::with('subcharts')->get();

        //petty cash account
        $petty = 'Petty Cash';

        //get the monies in pettycash account
        $pettycashAccount = Chart::where('accountName', '=', $petty)->pluck('money');

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Saving::where('bank', '=', $eq)->sum('debit');

        //we need to equally produce monies deposited by members via equity account.
        $equityDeposit = Account::where('bank', '=', 'Equity Bank')->sum('money');

        //we need to get all summations that have been disbursed from equity bank
        $equitySumDisburse  = Disbursement::where('bank', '=', 'Equity Bank')->sum('disburseMoney');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityReimburse    = Installment::where('bank', '=', 'Equity Bank')->sum('installment');

        //equity bank opening balance
        $equityopeningbalance = Chart::where('accountName', '=', 'Equity Opening Balance')->pluck('money');

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->sum('overpay');

        //get the total expense.
        $equitySumJournal = $actualFigureEquity + $overpayEquity;

        //then get the coop account's aggregate.
        $equityAggregate = ($equityopeningbalance + $equityDeposit + $equityReimburse) - ($equityAccount + $equitySumDisburse + $equitySumJournal);

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Saving::where('bank', '=', $coop)->sum('credit');

        //we need to equally produce monies deposited by members via coop account.
        $coopDeposit = Account::where('bank', '=', 'Co-op Bank')->sum('money');        

        //we need to get all loans that have been disbursed from equity bank
        $coopSumDisburse  = Disbursement::where('bank', '=', 'Coop Bank')->sum('disburseMoney');

        //also we need to produce monies that have been paid as loan reimbursements via coop account.
        $coopSumReimburse = Installment::where('bank', '=', 'Co-op Bank')->sum('installment');

        //get the opening balance of each bank.
        $coopopeningbalance   = Chart::where('accountName', '=', 'Co-op Opening Balance')->pluck('money');

        //get equity running balance
        $coopRunning = ($coopopeningbalance + $coopDeposit + $coopSumReimburse) - ($coopAccount + $coopSumDisburse);

        //then get the coop account's aggregate.
        $coopAggregate = $coopRunning + $equityAggregate + $pettycashAccount;

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.coopCashbook', compact('equitySumJournal', 'equityJournal', 'coopRunning', 'coopopeningbalance', 'coopDeposit', 'coopSumDisburse', 'coopSumReimburse', 'coopDisburse', 'coopAggregate', 'memberLoanPayments', 'depositsCoop', 'coopAccount', 'equityAccount', 'charts', 'savings', 'last'))
                ->with('title', $title);
        }
        else {

            return View('auth.coopCashbook', compact('savings'))
            ->with('title', $title);
        }
    }

    /**
    ** equity bank Cash book.
    **/
    public function equityCashbook() {

        $title = 'Equity Bank Cash Book.';

        //get the savings via id.
        $savings = Auth::user()->savings()->where('bank', '=', 'Equity Bank')->orderBy('created_at', 'desc')->get();

        //get all members that have made deposits via co-op bank.
        $depositsEquity = Account::where('bank', '=', 'Equity Bank')->with('member')->orderBy('created_at', '=', 'desc')->get();

        //get all members that have made loan payments via loan=>installments under co-op bank.
        $memberLoanPayments = Installment::where('bank', '=', 'Equity Bank')->with('loan')->orderBy('created_at', '=', 'desc')->get();
        
        //we need to get all loans that have been disbursed from equity bank
        $equityDisburse  = Disbursement::where('bank', '=', 'Equity Bank')->orderBy('created_at', '=', 'desc')->get();

        //get the journal plus its data.
        $equityJournal   = Journal::where('bank', '=', 'Equity Bank')->orderBy('created_at', 'desc')->get();

        //get the chart of accounts.
        $charts = Chart::with('subcharts')->get();

        //petty cash account
        $petty = 'Petty Cash';

        //get the monies in pettycash account
        $pettycashAccount = Chart::where('accountName', '=', $petty)->pluck('money');

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Saving::where('bank', '=', $eq)->sum('debit');

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Saving::where('bank', '=', $coop)->sum('credit');

        //we need to equally produce monies deposited by members via coop account.
        $coopDeposit = Account::where('bank', '=', 'Co-op Bank')->sum('money');

        //we need to get all loans that have been disbursed from equity bank
        $coopSumDisburse  = Disbursement::where('bank', '=', 'Coop Bank')->sum('disburseMoney');

        //also we need to produce monies that have been paid as loan reimbursements via coop account.
        $coopReimburse = Installment::where('bank', '=', 'Co-op Bank')->sum('installment');

        //get the opening balance of each bank.
        $coopopeningbalance   = Chart::where('accountName', '=', 'Co-op Opening Balance')->pluck('money');

        //then get the coop account's aggregate.
        $coopAggregate = ($coopopeningbalance + $coopDeposit + $coopReimburse) - ($coopAccount + $coopSumDisburse);

        //we need to equally produce monies deposited by members via equity account.
        $equityDeposit = Account::where('bank', '=', 'Equity Bank')->sum('money');

        //equity bank opening balance
        $equityopeningbalance = Chart::where('accountName', '=', 'Equity Opening Balance')->pluck('money');

        //we need to get all summations that have been disbursed from equity bank
        $equitySumDisburse  = Disbursement::where('bank', '=', 'Equity Bank')->sum('disburseMoney');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equitySumReimburse   = Installment::where('bank', '=', 'Equity Bank')->sum('installment');

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->sum('overpay');

        //get the total expense.
        $equitySumJournal = $actualFigureEquity + $overpayEquity;

        //get equity running balance
        $equityRunning = ($equityopeningbalance + $equityDeposit + $equitySumReimburse) - ($equityAccount + $equitySumDisburse + $equitySumJournal);

        //then get the coop account's aggregate.
        $equityAggregate = ($equityRunning + $coopAggregate + $pettycashAccount);
        

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.equityCashbook', compact('equitySumJournal', 'equityJournal', 'equitySumDisburse', 'equitySumReimburse', 'equityRunning', 'pettycashAccount', 'equityopeningbalance', 'equityDisburse', 'equityDeposit',  'equityAggregate', 'depositsEquity', 'memberLoanPayments', 'coopAccount', 'equityAccount', 'charts', 'savings', 'last', 'cash'))
                ->with('title', $title);
        }
        else {

            return View('auth.equityCashbook', compact('coopAccount', 'equityAccount', 'charts', 'savings', 'sumcredit', 'sumdebit', 'cash'))
            ->with('title', $title);
        }
    }

    /**
    ** Petty Cash Cash book.
    **/
    public function pettyCashbook() {

        $title = 'Petty Cash Cash Book.';

        //get the savings via id.
        $savings = Auth::user()->savings()->where('bank', '=', 'Petty Cash')->orderBy('created_at', 'desc')->get();
        
        //get the chart of accounts.
        $charts = Chart::with('subcharts')->get();

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Saving::where('bank', '=', $eq)->sum('debit');

        //get the journal plus its data.
        $equityJournal   = Journal::where('bank', '=', 'Equity Bank')->orderBy('created_at', 'desc')->get();

        //petty cash account
        $petty = 'Petty Cash';

        //get the monies in pettycash account
        $pettycashAccount = Chart::where('accountName', '=', $petty)->pluck('money');

        //get pettycash bank's opening balance
        $pettycashopeningbalance = Chart::where('accountName', '=', 'Petty Cash Opening Balance')->pluck('money');

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Saving::where('bank', '=', $coop)->sum('credit');

        //we need to equally produce monies deposited by members via coop account.
        $coopDeposit = Account::where('bank', '=', 'Co-op Bank')->sum('money');

        //we need to get all loans that have been disbursed from equity bank
        $coopDisburse  = Disbursement::where('bank', '=', 'Coop Bank')->sum('disburseMoney');

        //also we need to produce monies that have been paid as loan reimbursements via coop account.
        $coopReimburse = Installment::where('bank', '=', 'Co-op Bank')->sum('installment');

        //get the opening balance of each bank.
        $coopopeningbalance = Chart::where('accountName', '=', 'Co-op Opening Balance')->pluck('money');

        //then get the coop account's aggregate.
        $coopAggregate = ($coopopeningbalance + $coopDeposit + $coopReimburse) - ($coopAccount + $coopDisburse);

        //we need to equally produce monies deposited by members via equity account.
        $equityDeposit = Account::where('bank', '=', 'Equity Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityReimburse = Installment::where('bank', '=', 'Equity Bank')->sum('installment');

        //we need to get all loans that have been disbursed from equity bank
        $equityDisburse  = Disbursement::where('bank', '=', 'Equity Bank')->sum('disburseMoney');

        $equityopeningbalance = Chart::where('accountName', '=', 'Equity Opening Balance')->pluck('money');

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->sum('overpay');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->sum('overpay');

        //get the total expense.
        $equitySumJournal = $actualFigureEquity + $overpayEquity;

        //then get the coop account's aggregate.
        $equityAggregate = ($equityopeningbalance + $equityDeposit + $equityReimburse) - ($equityAccount + $equityDisburse + $equitySumJournal);

        $pettycashAggregate = $equityAggregate + $coopAggregate + $pettycashAccount;

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.pettyCashbook', compact('equityJournal', 'equitySumJournal', 'pettycashAggregate', 'pettycashAccount', 'pettycashopeningbalance', 'equityopeningbalance', 'equityDisburse', 'equityDeposit', 'equityLoan', 'depositsEquity', 'memberLoanPayments', 'coopAccount', 'equityAccount', 'charts', 'savings', 'last', 'sumcredit', 'sumdebit', 'cash'))
                ->with('title', $title);
        }
        else {

            return View('auth.pettyCashbook', compact('coopAccount', 'equityAccount', 'charts', 'savings', 'sumcredit', 'sumdebit', 'cash'))
            ->with('title', $title);
        }
    }

    /**
    ** Create cash book.
    **/
    public function createCashbook() {

        $title = ' Create Cashbook.';

        //get the chart of accounts.
        $charts = Chart::with('subcharts')->get();

        return View('auth.createCashbook', compact('charts'))
            ->with('title', $title);
    }

    /**
    ** Profit and loss.
    **/
    public function profitLoss() {

        $title = 'Profit & Loss.';

        //get the savings via id.
        $savings = Auth::user()->savings()->orderBy('created_at', 'desc')->get();
        
        //get the chart of accounts.
        $charts = Chart::where('accountName', '!=', 'Equity Bank')->where('accountName', '!=', 'Coop Bank')->with('subcharts')->get();             

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Chart::where('accountName', '=', $eq)->pluck('money');

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Chart::where('accountName', '=', $coop)->pluck('money');

        //petty cash account
        $petty = 'Petty Cash';

        //get the monies in pettycash account
        $pettycashAccount = Chart::where('accountName', '=', $petty)->pluck('money');

        //get the cash from coop bank in our cash book.
        $debits  = DB::table('savings')->where('action', '=', 'debit')->get();

        $credits = DB::table('savings')->where('action', '=', 'credit')->get();

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->sum('overpay');

        //get the total expense.
        $sumJournal = $actualFigureEquity + $overpayEquity;

        //get the journals.
        $journals = DB::table('journals')->get();

        //get the summations of debits and credits.
        $sumdebit   = DB::table('savings')->where('action', '=', 'debit')->sum('debit');

        $sumcredit  = DB::table('savings')->where('action', '=', 'credit')->sum('credit');

        //get the running balance.
        $runningBal = $coopAccount + $equityAccount;

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Chart::where('accountName', '=', $coop)->pluck('money');

        //we need to equally produce monies deposited by members via coop account.
        $coopDeposit = Account::where('bank', '=', 'Co-op Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via coop account.
        $coopLoan    = Installment::where('bank', '=', 'Co-op Bank')->sum('installment');

        //then get the coop account's aggregate.
        $coopAggregate = $coopAccount + $coopDeposit + $coopLoan;

        //we need to equally produce monies deposited by members via equity account.
        $equityDeposit = Account::where('bank', '=', 'Equity Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityLoan    = Installment::where('bank', '=', 'Equity Bank')->sum('installment');

        //then get the coop account's aggregate.
        $equityAggregate = $equityAccount + $equityDeposit + $equityLoan;

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.profitLoss', compact('journals', 'sumJournal', 'pettycashAccount', 'coopAggregate', 'equityAggregate', 'runningBal', 'sumdebit', 'sumcredit', 'debits', 'credits', 'coopAccount', 'equityAccount', 'charts', 'savings', 'last'))
                ->with('title', $title);
        }
        else {

            return View('auth.profitLoss', compact('savings'))
            ->with('title', $title);
        }
    }

    /**
    ** Balance Sheet.
    **/
    public function balanceSheet() {

        $title = 'Balance Sheet.';

        //get the savings via id.
        $savings = Auth::user()->savings()->orderBy('created_at', 'desc')->get();

        //get the chart of accounts.
        $charts = Chart::with('subcharts')->get();   

        //$charts = Chart::where('accountName', '!=', 'Equity Bank')->where('accountName', '!=', 'Coop Bank')->with('subcharts')->get();     

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Chart::where('accountName', '=', $eq)->pluck('money');

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Chart::where('accountName', '=', $coop)->pluck('money');

        //petty cash account
        $petty = 'Petty Cash';

        //get the monies in pettycash account
        $pettycashAccount = Chart::where('accountName', '=', $petty)->pluck('money');

        //get the cash from coop bank in our cash book.
        $debits  = DB::table('savings')->where('action', '=', 'debit')->get();

        $credits = DB::table('savings')->where('action', '=', 'credit')->get();

        //get the summations of debits and credits.
        $sumdebit   = DB::table('savings')->where('action', '=', 'debit')->sum('debit');

        $sumcredit  = DB::table('savings')->where('action', '=', 'credit')->sum('credit');

        //get the running balance.
        $runningBal = $coopAccount + $equityAccount;

        //get the summation of all member deposits.
        $memberDeposits = DB::table('accounts')->sum('money');

        //get all the loans.
        $memberLoans    = DB::table('loans')->sum('loan');

        //get all the installments.
        $memberInstallments   = Chart::where('accountName', '=', 'Reimbursements')->pluck('money');

        //get all consulting Income account.
        $consultIncome  = DB::table('charts')->where('accountName', '=', 'Consulting Income')->pluck('detail');

        //get all interest Income on loans account.
        $interestIncome  = DB::table('charts')->where('accountName', '=', 'Interest Income')->pluck('detail');

        //get the income from the chart of accounts.
        $reimbursementsChart = Chart::where('accountName', '=', 'Reimbursements')->pluck('detail');

        //get all the incomes.
        $income = $consultIncome + $interestIncome;


        //we need to equally produce monies deposited by members via coop account.
        $coopDeposit = Account::where('bank', '=', 'Co-op Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via coop account.
        $coopLoan    = Installment::where('bank', '=', 'Co-op Bank')->sum('installment');

        //then get the coop account's aggregate.
        $coopAggregate = $coopAccount + $coopDeposit + $coopLoan;

        //we need to equally produce monies deposited by members via equity account.
        $equityDeposit = Account::where('bank', '=', 'Equity Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityLoan    = Installment::where('bank', '=', 'Equity Bank')->sum('installment');

        //then get the coop account's aggregate.
        $equityAggregate = $equityAccount + $equityDeposit + $equityLoan;

        //get all loan disbursements.
        $loanDisbursements = Disbursement::sum('disburseMoney');

        //sum all fixed assets of the chart table.
        $fixedchart = Chart::where('category', '=', 'Fixed Asset')->sum('detail');

        //sum all fixed assets of the subchart table.
        $fixedsubchart = Subchart::where('category', '=', 'Fixed Asset')->sum('detail');

        //get the summations of all the fixed assets.
        $fixedassetsummation = $fixedchart + $fixedsubchart;

        //sum up all the expense accounts.
        $expensesummation = Chart::where('category', '=', 'expense')->orWhere('category', '=', 'utility')->sum('detail');

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.balanceSheet', compact('pettycashAccount', 'expensesummation', 'reimbursementsChart', 'fixedassetsummation', 'loanDisbursements', 'memberInstallments', 'coopAggregate', 'equityAggregate', 'income', 'memberLoans', 'memberDeposits', 'coopAccount', 'equityAccount', 'charts', 'savings', 'last', 'sumcredit', 'sumdebit', 'cash'))
                ->with('title', $title);
        }
        else {

            return View('auth.balanceSheet', compact('savings'))
            ->with('title', $title);
        }
    }

    /**
    ** Trial Balance
    **/
    public function trialBalance()
    {
        $title = 'Trial Balance.';

        //get the savings via id.
        $balances = Auth::user()->savings()->orderBy('created_at', 'desc')->paginate(50);

        //check the debit column in our db in its totality and sum it up.
        $sumcredit = Auth::user()->savings()->sum('credit');

        //sum up all the debit from our db.
        $sumdebit  = Auth::user()->savings()->sum('debit');

        // This will hold the count for you
        $cash = $sumcredit - $sumdebit;

        $prop = Auth::user()->savings()->count();
        
        //get the chart of accounts.
        $charts = Chart::where('accountName', '!=', 'Equity Bank')->where('accountName', '!=', 'Coop Bank')->with('subcharts')->get();

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Chart::where('accountName', '=', $eq)->pluck('money');

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Chart::where('accountName', '=', $coop)->pluck('money');

        //petty cash account
        $petty = 'Petty Cash';

        //get the monies in pettycash account
        $pettycashAccount = Chart::where('accountName', '=', $petty)->pluck('money');

        //get the cash from coop bank in our cash book.
        $debits  = DB::table('savings')->where('action', '=', 'debit')->get();

        $credits = DB::table('savings')->where('action', '=', 'credit')->get();

        //get the summations of debits and credits.
        $sumdebit   = DB::table('savings')->where('action', '=', 'debit')->sum('debit');

        $sumcredit  = DB::table('savings')->where('action', '=', 'credit')->sum('credit');

        //get the summations of all the monies in our chart and subchart accounts.
        $chartsummations = Chart::where('category', '!=', 'bank')->with('subcharts')->sum('money');

        //get the running balance.
        $runningBal = $coopAccount + $equityAccount;

        //get the summation of all member deposits.
        $memberDeposits = DB::table('accounts')->sum('money');

        //get all the loans.
        $memberLoans    = DB::table('loans')->sum('loan');

        //get all the installments.
        $memberInstallments   = Installment::sum('installment');


        //we need to equally produce monies deposited by members via coop account.
        $coopDeposit = Account::where('bank', '=', 'Co-op Bank')->sum('money');

        //also we need to produce monies that have been paid as loan disbursements via coop account.
        $coopDismburse = Disbursement::where('bank', '=', 'Co-op Bank')->sum('disburseMoney');

        //also we need to produce monies that have been paid as loan reimbursements via coop account.
        $coopReimburse = Installment::where('bank', '=', 'Co-op Bank')->sum('installment');

        //then get the coop account's aggregate.
        $coopAggregate = ($coopAccount + $coopDeposit + $coopReimburse) - $coopDismburse;


        //we need to equally produce monies deposited by members via equity account.
        $equityDeposit = Account::where('bank', '=', 'Equity Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityDismburse = Disbursement::where('bank', '=', 'Equity Bank')->sum('disburseMoney');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityReimburse = Installment::where('bank', '=', 'Equity Bank')->sum('installment');

        //then get the coop account's aggregate.
        $equityAggregate = ($equityAccount + $equityDeposit + $equityReimburse) - $equityDismburse;

        //get all loan disbursements.
        $loanDisbursements = Disbursement::sum('disburseMoney');

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');

            return View('auth.trialBalance', compact('pettycashAccount', 'chartsummations', 'loanDisbursements', 'memberLoans', 'memberDeposits', 'memberInstallments', 'coopAggregate', 'equityAggregate', 'coopAccount', 'equityAccount', 'charts', 'balances', 'cash', 'last', 'sumcredit', 'sumdebit'))
                ->with('title', $title);
        }
        else {

            return View('auth.trialBalance', compact('balances'))
                ->with('title', $title);
        }    
    }

    /**
    ** PDF coop cash book.
    **/
    public function pdfcoopCashbook() {

        $title = 'PDF Co - op Bank Cashbook.';

        //get the savings via id.
        $savings = [

            'savings' => Auth::user()->savings()->where('bank', '=', 'Co-op Bank')->orderBy('created_at', 'desc')->get()
        ];

        //get all members that have made deposits via co-op bank.
        $depositsCoop = Account::where('bank', '=', 'Co-op Bank')->with('member')->get();

        //get all members that have made loan payments via loan=>installments under co-op bank.
        $memberLoanPayments = Installment::with('loan')->get();

        //check the debit column in our db in its totality and sum it up.
        $sumcredit = Auth::user()->savings()->sum('credit');

        //sum up all the debit from our db.
        $sumdebit  = Auth::user()->savings()->sum('debit');

        // This will hold the count for you
        $cash = $sumcredit - $sumdebit;

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the user id.
        $userId = Auth::user()->id;
        
        //get the chart of accounts.
        $charts = Chart::with('subcharts')->where('user_id', '=', $userId)->get();

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Chart::where('accountName', '=', $eq)->pluck('money');

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Chart::where('accountName', '=', $coop)->pluck('money');

        //we need to equally produce monies deposited by members via coop account.
        $coopDeposit = Account::where('bank', '=', 'Co-op Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via coop account.
        $coopLoan    = Installment::where('bank', '=', 'Co-op Bank')->sum('installment');

        //then get the coop account's aggregate.
        $coopAggregate = $coopAccount + $coopDeposit + $coopLoan;

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->where('bank', '=', 'Co-op Bank')->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');

            $pdf = PDF::loadView('pdf.coopCashbookPDF', $savings, compact('coopDeposit', 'coopLoan', 'coopAggregate', 'memberLoanPayments', 'depositsCoop', 'coopAccount', 'equityAccount', 'charts', 'last', 'sumcredit', 'sumdebit', 'cash'))->setPaper('a3', 'landscape');

            return $pdf->stream('Co - op Bank Cashbook.pdf');
        }
    }

    /**
    ** PDF equity cash book.
    **/
    public function pdfequityCashbook() {

        $title = 'PDF Equity Bank Cashbook.';

        //get the savings via id.
        $savings = [

            'savings' => Auth::user()->savings()->where('bank', '=', 'Equity Bank')->orderBy('created_at', 'desc')->get()
        ];

        //get all members that have made deposits via equity bank.
        $depositsEquity = Account::where('bank', '=', 'Equity Bank')->with('member')->get();

        //get all members that have made loan payments via loan=>installments under co-op bank.
        $memberLoanPayments = Installment::where('bank', '=', 'Equity Bank')->with('loan')->get();

        //check the debit column in our db in its totality and sum it up.
        $sumcredit = Auth::user()->savings()->sum('credit');

        //sum up all the debit from our db.
        $sumdebit  = Auth::user()->savings()->sum('debit');

        // This will hold the count for you
        $cash = $sumcredit - $sumdebit;

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the user id.
        $userId = Auth::user()->id;
        
        //get the chart of accounts.
        $charts = Chart::with('subcharts')->where('user_id', '=', $userId)->get();

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Chart::where('accountName', '=', $eq)->pluck('money');

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Chart::where('accountName', '=', $coop)->pluck('money');

        //we need to equally produce monies deposited by members via equity account.
        $equityDeposit = Account::where('bank', '=', 'Equity Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityLoan    = Installment::where('bank', '=', 'Equity Bank')->sum('installment');

        //then get the coop account's aggregate.
        $equityAggregate = $equityAccount + $equityDeposit + $equityLoan;

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->where('bank', '=', 'Equity Bank')->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');

            $pdf = PDF::loadView('pdf.equityCashbookPDF', $savings, compact('equityDeposit', 'equityLoan', 'coopAggregate', 'equityAggregate', 'depositsEquity', 'memberLoanPayments', 'coopAccount', 'equityAccount', 'charts', 'last', 'sumcredit', 'sumdebit', 'cash'))->setPaper('a3', 'landscape');

            return $pdf->stream('Equity Bank Cashbook.pdf');
        }
    }

    /**
    ** PDF equity cash book.
    **/
    public function pdfpettyCashbook() {

        $title = 'PDF Petty Cash Cashbook.';

        //get the savings via id.
        $savings = [

            'savings' => Auth::user()->savings()->where('bank', '=', 'Petty Cash')->orderBy('created_at', 'desc')->get()
        ];       
        
        //get the chart of accounts.
        $charts = Chart::with('subcharts')->get();

        //petty cash account
        $petty = 'Petty Cash';

        //get the monies in pettycash account
        $pettycashAccount = Chart::where('accountName', '=', $petty)->pluck('money');

        //get pettycash bank's opening balance
        $pettycashopeningbalance = Chart::where('accountName', '=', 'Petty Cash Opening Balance')->pluck('money');

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Chart::where('accountName', '=', $eq)->pluck('money');

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Chart::where('accountName', '=', $coop)->pluck('money');

        //we need to equally produce monies deposited by members via equity account.
        $equityDeposit = Account::where('bank', '=', 'Equity Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityLoan    = Installment::where('bank', '=', 'Equity Bank')->sum('installment');

        //then get the coop account's aggregate.
        $equityAggregate = $equityAccount + $equityDeposit + $equityLoan;

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->where('bank', '=', 'Petty Cash')->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');

            $pdf = PDF::loadView('pdf.pettyCashbookPDF', $savings, compact('pettycashopeningbalance', 'pettycashAccount', 'coopAggregate', 'equityAggregate', 'coopAccount', 'equityAccount', 'charts', 'last', 'sumcredit', 'sumdebit', 'cash'))->setPaper('a3', 'landscape');

            return $pdf->stream('Petty Cash Cashbook.pdf');
        }
    }

    /**
    ** PDF profit and loss.
    **/
    public function pdfProfitLoss() {

        //get the savings via id.
        $savings = [

            'savings' => Auth::user()->savings()->orderBy('created_at', 'desc')->get()
        ];

        //get the chart of accounts.
        $charts = Chart::with('subcharts')->get();

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Chart::where('accountName', '=', $eq)->pluck('money');

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Chart::where('accountName', '=', $coop)->pluck('money');

        //petty cash account
        $petty = 'Petty Cash';

        //get the monies in pettycash account
        $pettycashAccount = Chart::where('accountName', '=', $petty)->pluck('money');

        //get the cash from coop bank in our cash book.
        $debits  = DB::table('savings')->where('action', '=', 'debit')->get();

        $credits = DB::table('savings')->where('action', '=', 'credit')->get();

        //get the summations of debits and credits.
        $sumdebit   = DB::table('savings')->where('action', '=', 'debit')->sum('debit');

        $sumcredit  = DB::table('savings')->where('action', '=', 'credit')->sum('credit');

        //get the running balance.
        $runningBal = $coopAccount + $equityAccount;

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->sum('overpay');

        //get the total expense.
        $sumJournal = $actualFigureEquity + $overpayEquity;

        //gain access to all journals.
        $journals = DB::table('journals')->get();

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();       

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');

            $pdf = PDF::loadView('pdf.profitLossPDF', $savings, compact('sumJournal', 'journals', 'pettycashAccount', 'runningBal', 'sumdebit', 'sumcredit', 'debits', 'credits', 'coopAccount', 'equityAccount', 'charts', 'last', 'sumcredit', 'sumdebit', 'cash'))->setPaper('a3', 'portrait');

            return $pdf->stream('Profit & Loss.pdf');
        }
    }

    /**
    ** PDF Balance Sheet.
    **/
    public function pdfBalanceSheet() {

        $title = 'Balance Sheet.';

        //get the savings via id.
        $savings = Auth::user()->savings()->orderBy('created_at', 'desc')->get();

        //check the debit column in our db in its totality and sum it up.
        $sumcredit = Auth::user()->savings()->sum('credit');

        //sum up all the debit from our db.
        $sumdebit  = Auth::user()->savings()->sum('debit');

        // This will hold the count for you
        $cash = $sumcredit - $sumdebit;
        
        //get the chart of accounts.
        $charts = Chart::with('subcharts')->get();

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Chart::where('accountName', '=', $eq)->pluck('money');

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Chart::where('accountName', '=', $coop)->pluck('money');

        //petty cash account
        $petty = 'Petty Cash';

        //get the monies in pettycash account
        $pettycashAccount = Chart::where('accountName', '=', $petty)->pluck('money');

        //get the summation of all member deposits.
        $memberDeposits = DB::table('accounts')->sum('money');

        //get all the loans.
        $memberLoans    = DB::table('loans')->sum('loan');

        //get all the installments.
        $memberInstallments   = DB::table('installments')->sum('installment');

         //get all consulting Income account.
        $consultIncome  = DB::table('charts')->where('accountName', '=', 'Consulting Income')->pluck('detail');

        //get all interest Income on loans account.
        $interestIncome  = DB::table('charts')->where('accountName', '=', 'Interest Income')->pluck('detail');

        //get the income from the chart of accounts.
        $reimbursementsChart = Chart::where('accountName', '=', 'Reimbursements')->pluck('detail');

        //get all the incomes.
        $income = $consultIncome + $interestIncome;


        //we need to equally produce monies deposited by members via coop account.
        $coopDeposit = Account::where('bank', '=', 'Co-op Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via coop account.
        $coopLoan    = Installment::where('bank', '=', 'Co-op Bank')->sum('installment');

        //then get the coop account's aggregate.
        $coopAggregate = $coopAccount + $coopDeposit + $coopLoan;


        //we need to equally produce monies deposited by members via equity account.
        $equityDeposit = Account::where('bank', '=', 'Equity Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityLoan    = Installment::where('bank', '=', 'Equity Bank')->sum('installment');

        //then get the coop account's aggregate.
        $equityAggregate = $equityAccount + $equityDeposit + $equityLoan;

        //get all loan disbursements.
        $loanDisbursements = Disbursement::sum('disburseMoney');

        //sum all fixed assets of the chart table.
        $fixedchart = Chart::where('category', '=', 'Fixed Asset')->sum('detail');

        //sum all fixed assets of the subchart table.
        $fixedsubchart = Subchart::where('category', '=', 'Fixed Asset')->sum('detail');

        //get the summations of all the fixed assets.
        $fixedassetsummation = $fixedchart + $fixedsubchart;

        //sum up all the expense accounts.
        $expensesummation = Chart::where('category', '=', 'expense')->orWhere('category', '=', 'utility')->sum('detail');

        //count the records in the savings table to see if there is any record.
        $prop = Auth::user()->savings()->count();


        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            $pdf = PDF::loadView('pdf.balanceSheetPDF', $savings,  compact('pettycashAccount', 'expensesummation', 'fixedassetsummation', 'reimbursementsChart', 'income', 'loanDisbursements', 'memberInstallments', 'memberDeposits', 'memberLoans', 'coopAggregate', 'equityAggregate', 'coopAccount', 'equityAccount', 'charts', 'savings', 'last', 'sumcredit', 'sumdebit', 'cash'))->setPaper('a3', 'portrait');
            
            return $pdf->stream('Balance Sheet.pdf');
        }    
    }

    /**
    ** PDF Trial Balance
    **/
    public function pdfTrialBalance()
    {
        $title = 'PDF Trial Balance.';

        $balances = [

            'balances' => Auth::user()->savings()->orderBy('created_at', 'desc')->get()
        ];

        //get the cash from coop bank in our cash book.
        $debits  = DB::table('savings')->where('action', '=', 'debit')->get();

        $credits = DB::table('savings')->where('action', '=', 'credit')->get();

        //get the summations of debits and credits.
        $sumdebit   = DB::table('savings')->where('action', '=', 'debit')->sum('debit');

        $sumcredit  = DB::table('savings')->where('action', '=', 'credit')->sum('credit');
        
        //get the chart of accounts.
        $charts = Chart::where('accountName', '!=', 'Equity Bank')->where('accountName', '!=', 'Coop Bank')->with('subcharts')->get();

        //get the summations of all the monies in our chart and subchart accounts.
        $chartsummations = Chart::where('category', '!=', 'bank')->with('subcharts')->sum('money');

        //get equity bank.
        $eq     = 'Equity Bank';

        //we want to know how much money does each bank has in its account.
        //equity's account.
        $equityAccount = Chart::where('accountName', '=', $eq)->pluck('money');

        //get co-op bank.
        $coop = 'Co-op Bank';

        //we want to know how much money does each bank has in its account.
        //coop's account.
        $coopAccount = Chart::where('accountName', '=', $coop)->pluck('money');

        //petty cash account
        $petty = 'Petty Cash';

        //get the monies in pettycash account
        $pettycashAccount = Chart::where('accountName', '=', $petty)->pluck('money');

        //get the summation of all member deposits.
        $memberDeposits = DB::table('accounts')->sum('money');

        //get all the loans.
        $memberLoans    = DB::table('loans')->sum('loan');

        //get all the installments.
        $memberInstallments   = DB::table('installments')->sum('installment');


        //we need to equally produce monies deposited by members via coop account.
        $coopDeposit = Account::where('bank', '=', 'Co-op Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via coop account.
        $coopLoan    = Installment::where('bank', '=', 'Co-op Bank')->sum('installment');

        //then get the coop account's aggregate.
        $coopAggregate = $coopAccount + $coopDeposit + $coopLoan;
        

        //we need to equally produce monies deposited by members via equity account.
        $equityDeposit = Account::where('bank', '=', 'Equity Bank')->sum('money');

        //also we need to produce monies that have been paid as loan reimbursements via equity account.
        $equityLoan    = Installment::where('bank', '=', 'Equity Bank')->sum('installment');

        //then get the coop account's aggregate.
        $equityAggregate = $equityAccount + $equityDeposit + $equityLoan;

        //get all loan disbursements.
        $loanDisbursements = Disbursement::sum('disburseMoney');

        $prop = Auth::user()->savings()->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Auth::user()->savings()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');

            //pass in the items to the pdf for printing purposes
            $pdf = PDF::loadView('pdf.trialBalancePdf', $balances, compact('pettycashAccount', 'chartsummations', 'loanDisbursements', 'memberLoans', 'memberDeposits', 'memberInstallments', 'coopAggregate', 'equityAggregate', 'coopAccount', 'equityAccount', 'charts', 'cash', 'last', 'sumcredit', 'sumdebit'))->setPaper('a3', 'portrait');

            return $pdf->stream('Trial Balance.pdf');
        }   
    }

    /**
     * Ledgers
     */
    public function ledgers()
    {
        $title = 'Ledgers.';

        //get all the members.
        $memberz = Member::paginate(30);

        return View('auth.ledgers', [ 'memberz' => $memberz])
            ->with('title', $title);
    }

    /**
     * Tabular Mature Loans
     */
    public function activeLedger()
    {
        $title = 'Active Loans.';

        //get all members with matured Loans
        //get all guarantors and their respective guarantees
        $activeLoans = Member::where('loanStatus', '=', 1)->with('loan')->get();

        return View('auth.members.activeMembers', compact('activeLoans'))
            ->with('title', $title);
    }

    /**
    ** Loan Guarantors.
    **/
    public function loanGuarantors($id) {

        $title = 'Loan Guarantors.';

        //find the loan via its id.
        $loan = Loan::find($id);

        //we need to unserialize the guarantees.
        $guarantees = unserialize($loan->guarantees);

        return View('auth.loanGuarantors', compact('loan', 'guarantees'))
            ->with('title', $title);
    }

    /**
    ** Guarantors
    **/
    public function guarantorsLedger()
    {
        $title = 'Guarantors.';

        return View('auth.members.guarantorMembers')
            ->with('title', $title);
    }

    /**
    ** Deposits Ledger.
    **/
    public function depositsLedger() {

        $title = 'Member Deposits.';

        //get all members in regard to their deposits.
        $deposits = Member::orderBy('totals', 'desc')->get();

        //total deposits
        $depositSum = Member::sum('totals');

        return View('auth.members.depositsMembersLedger', compact('deposits'))
            ->with('title', $title);
    }

    /**
    ** Loan Disbursements Ledger.
    **/
    public function loanDisburseLedger() {

        $title = 'Loan Disbursement Ledger.';

        $disburses = DB::table('disbursements')->get();

        return View('auth.loanDisbursementLedger', compact('disburses'))
            ->with('title', $title);
    }

    /**
    ** Loan Reimburse Ledger.
    **/
    public function loanReimburseLedger() {

        $title = 'Loan Reimbursement Ledger.';

        $reimburses = DB::table('installments')->get();

        return View('auth.loanReimburseLedger', compact('reimburses'))
            ->with('title', $title);
    }

    /**
    ** PDF Disbursements Ledger.
    **/
    public function pdfLoanDisburse() {

        $title = 'Loan Disbursements.';

        //get all loan disbursements.
        $disburses = [
            
            'disburses' => DB::table('disbursements')->get()
        ];

        //count the records in the savings table to see if there is any record.
        $prop = DB::table('disbursements')->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Member::latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            $pdf = PDF::loadView('pdf.loanDisbursementsPDF', $disburses, compact('last'))->setPaper('a3', 'portrait');

            return $pdf->stream('Loan Disbursements.pdf');
        }
    }

    /**
     * PDF Guarantors
     */
    public function pdfGuarantors()
    {
        $title = 'PDF Guarantors.';


        //get all loan defaulters.
        $guarantors = [
            
            'guarantors' => Member::where('guaranteeStatus', '=', 1)->get()
        ];

        //count the records in the savings table to see if there is any record.
        $prop = DB::table('members')->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Member::latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            $pdf = PDF::loadView('pdf.guarantorsPdf', $guarantors, compact('last'))->setPaper('a3', 'landscape');

            return $pdf->stream('Guarantors.pdf');
        }

        //get all loan defaulters.
        $defaulters = Installment::where('defaults', '=', 1)->get();

        return View('auth.members.defaulterMembers', compact('defaulters'))
            ->with('title', $title);
    }

    /**
     * PDF Member Depositis
     */
    public function pdfDeposits()
    {
        $title = 'PDF Member Deposits.';


        //get all loan defaulters.
        $deposits = [
            
            'deposits' => Member::orderBy('totals', 'desc')->get()
        ];

        //count the records in the savings table to see if there is any record.
        $prop = DB::table('members')->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Member::latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            $pdf = PDF::loadView('pdf.depositsPdf', $deposits, compact('last'))->setPaper('a3', 'portrait');

            return $pdf->stream('Member Deposits.pdf');
        }

        //get all loan defaulters.
        $defaulters = Installment::where('defaults', '=', 1)->get();

        return View('auth.members.defaulterMembers', compact('defaulters'))
            ->with('title', $title);
    }

    /**
     * Tabular Defaulters
     */
    public function defaultersLedger()
    {
        $title = 'Defaulters.';

        //get all loan defaulters.
        $defaulters = Installment::where('defaults', '=', 1)->get();

        return View('auth.members.defaulterMembers', compact('defaulters'))
            ->with('title', $title);
    }

    /**
    ** PDF Loan Defaulters.
    **/
    public function pdfLoanDefaulters() {

        //get all loan defaulters.
        $defaulters = [
            
            'defaulters' => Installment::where('defaults', '=', 1)->get()
        ];

        //count the records in the savings table to see if there is any record.
        $prop = DB::table('installments')->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Installment::latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            $pdf = PDF::loadView('pdf.defaultersPdf', $defaulters, compact('last'))->setPaper('a3', 'landscape');

            return $pdf->stream('Defaulters.pdf');
        }
    }

    /**
    ** PDF Members
    **/
    public function pdfMembers()
    {
        $title = 'PDF Members.';

        $pageMembers = [

            'pageMembers' => Member::paginate(10)
        ];

        $pdf = PDF::loadView('pdf.membersPdf', $pageMembers)->setPaper('a2', 'landscape');

        return $pdf->stream('Members.pdf');
    }

    /**
    ** PDF Active Loans
    **/
    public function pdfActiveLoans()
    {
        $title = 'PDF Active Loans.';

        $activeLoans = [

            'activeLoans' => Member::where('loanStatus', '=', 1)->with('loan')->get()
        ];

        //count the records in the savings table to see if there is any record.
        $prop = DB::table('loans')->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Loan::latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            $pdf = PDF::loadView('pdf.loansPdf', $activeLoans, compact('last'))->setPaper('a2', 'portrait');

            return $pdf->stream('Loans.pdf');
        }
    }

    /**
    ** PDF Loan Guarantors.
    **/
    public function pdfLoanGuarantors($id) {

        $title = 'Loan Guarantors.';

        //find the loan via its id.
        $loan = Loan::find($id);

        //we need to unserialize the guarantees.
        $guarantees = unserialize($loan->guarantees);

        //count the records in the savings table to see if there is any record.
        $prop = DB::table('loans')->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Loan::latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            $pdf = PDF::loadView('pdf.loanGuarantorsPdf', compact('last', 'loan', 'guarantees'))->setPaper('a2', 'portrait');

            return $pdf->stream('Loan Guarantors.pdf');
        }
    }

    /**
    ** Balances Yesterday.
    **/
    public function balancesYesterday() {

        $title = 'Yesterday Balances.';

        //grab yesterday's timelines.
        //start of yesterday ie 00:00:00
        $yesterdayStart = Carbon::yesterday('Africa/Nairobi')->startOfDay();

        //end of yesterday ie 23:59:59
        $yesterdayEnd   = Carbon::yesterday('Africa/Nairobi')->endOfDay();

        //day before yesterday begining of the day
        $minusonedaystart = Carbon::yesterday('Africa/Nairobi')->startOfDay()->subDays(1)->startOfDay();

        //day before yesterday end of the day
        $minusonedayend   = Carbon::yesterday('Africa/Nairobi')->endOfDay()->subDays(1)->endOfDay();


        /**
        ** Day before yesterday for opening balance purposes.
        **/
        //cashbook account operations that happened jana.
        $cashbookBeforeYesterday  = Saving::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->get();

        //get the cashbook monies debit
        $cashbookBeforeSumYesterdayDebit   = Saving::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->where('action', '=', 'debit')->sum('debit');

        //get the cashbook monies credit
        $cashbookBeforeSumYesterdayCredit  = Saving::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->where('action', '=', 'credit')->sum('credit');

        //display deposits that were done yesterday.
        $depositsBeforeYesterday  = Account::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->get();

        //sum up all the deposits
        $depositsBeforeSumYesterday  = Account::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->sum('money');

        //display all disbursements that were done yesterday.
        $disburseBeforeYesterday  = Disbursement::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->get();

        //sum up all the disbursed money
        $disburseBeforeSumYesterday  = Disbursement::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->sum('disburseMoney');
        
        //display all reimbursements/installments that were done yesterday.
        $reimburseBeforeYesterday = Installment::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->get();

        //sum up all the reimbursed money
        $reimburseBeforeSumYesterday = Installment::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->sum('installment');

        //get the journal plus its data.
        $equityJournalBeforeYesterday   = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->get();

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$minusonedaystart, $minusonedayend])->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$minusonedaystart, $minusonedayend])->sum('overpay');
        
        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$minusonedaystart, $minusonedayend])->sum('overpay');

        //get the total expense.
        $equitySumJournalBeforeYesterday = $actualFigureEquity + $overpayEquity;

        //get the day before yesterday's closing balance.
        $closingBalanceBeforeYesterday = ($depositsBeforeSumYesterday + $reimburseBeforeSumYesterday + $cashbookBeforeSumYesterdayCredit) - ($cashbookBeforeSumYesterdayDebit + $disburseBeforeSumYesterday + $equitySumJournalBeforeYesterday);
        /**
        ** Day before yesterday for opening balance purposes.
        **/

        //cashbook account operations that happened jana.
        $cashbookYesterday  = Saving::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->get();

        //get the cashbook monies debit
        $cashbookSumYesterdayDebit   = Saving::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->where('action', '=', 'debit')->sum('debit');

        //get the cashbook monies debit
        $cashbookSumYesterdayCredit  = Saving::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->where('action', '=', 'credit')->sum('credit');

        //display deposits that were done yesterday.
        $depositsYesterday  = Account::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->get();

        //sum up all the deposits
        $depositsSumYesterday  = Account::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->sum('money');

        //display all disbursements that were done yesterday.
        $disburseYesterday  = Disbursement::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->get();
        
        //sum up all the disbursed money
        $disburseSumYesterday  = Disbursement::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->sum('disburseMoney');

        //display all reimbursements/installments that were done yesterday.
        $reimburseYesterday = Installment::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->get();

        //sum up all the reimbursed money
        $reimburseSumYesterday = Installment::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->sum('installment');

        //get the journal plus its data.
        $equityJournalYesterday   = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->get();

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->sum('overpay');
        
        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->sum('overpay');

        //get the total expense.
        $equitySumJournalYesterday = $actualFigureEquity + $overpayEquity;

        //do a summation of all the cashbook transactions.
        $cashbookSumYesterday = $cashbookSumYesterdayCredit - $cashbookSumYesterdayDebit;

        //we need to get the closing balance of yesterday.
        $closingBalanceYesterday   = ($closingBalanceBeforeYesterday + $depositsSumYesterday + $reimburseSumYesterday + $cashbookSumYesterdayCredit) - ($cashbookSumYesterdayDebit + $disburseSumYesterday + $equitySumJournalYesterday);

        return View('auth.yesterdayBalance', compact('equitySumJournalYesterday', 'equityJournalYesterday', 'minusonedaystart', 'yesterdayEnd', 'yesterdayStart', 'closingBalanceBeforeYesterday', 'closingBalanceYesterday', 'cashbookSumYesterday', 'depositsSumYesterday', 'reimburseSumYesterday', 'disburseSumYesterday', 'cashbookYesterday', 'depositsYesterday', 'disburseYesterday', 'reimburseYesterday'))
            ->with('title', $title);
    }

    /**
    ** Balances Today.
    **/
    public function balancesToday() {

        $title = 'Today Balances.';

        //grab today's timelines.
        //start of today ie 00:00:00
        $TodayStart = Carbon::today('Africa/Nairobi')->startOfDay();

        //end of today ie 23:59:59
        $TodayEnd   = Carbon::today('Africa/Nairobi')->endOfDay();

        //day before today begining of the day
        $yestardayStart = Carbon::today('Africa/Nairobi')->startOfDay()->subDays(1)->startOfDay();

        //day before today end of the day
        $yestardayEnd   = Carbon::today('Africa/Nairobi')->endOfDay()->subDays(1)->endOfDay();

        $juziStart = Carbon::today('Africa/Nairobi')->startOfDay()->subDays(2)->startOfDay();

        //day before yesterday end of the day
        $juziEnd   = Carbon::today('Africa/Nairobi')->endOfDay()->subDays(2)->endOfDay();

        /**
        ** Juzi Before Yesterday
        **/
        //day before yesterday begining of the day

        //get the cashbook monies debit
        $cashbookJuziSumDebit   = Saving::whereBetween('created_at', [$juziStart, $juziEnd])->orderBy('created_at', 'desc')->where('action', '=', 'debit')->sum('debit');

        //get the cashbook monies credit
        $cashbookJuziSumCrebit  = Saving::whereBetween('created_at', [$juziStart, $juziEnd])->orderBy('created_at', 'desc')->where('action', '=', 'credit')->sum('credit');

        //sum up all the deposits
        $depositsJuziSum  = Account::whereBetween('created_at', [$juziStart, $juziEnd])->orderBy('created_at', 'desc')->sum('money');

        //sum up all the disbursed money
        $disburseJuziSum  = Disbursement::whereBetween('created_at', [$juziStart, $juziEnd])->orderBy('created_at', 'desc')->sum('disburseMoney');

        //sum up all the reimbursed money
        $reimburseJuziSum = Installment::whereBetween('created_at', [$juziStart, $juziEnd])->orderBy('created_at', 'desc')->sum('installment');

        //get the journal plus its data.
        //$equityJournalBefore = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$minustwodaystart, $minustwodayend])->orderBy('created_at', 'desc')->get();

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$juziStart, $juziEnd])->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$juziStart, $juziEnd])->sum('overpay');
        
        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$juziStart, $juziEnd])->sum('overpay');

        //get the total expense.
        $equityJournalJuziSum = $actualFigureEquity + $overpayEquity;

        //get the day before yesterday's closing balance.
        $closingBalanceJuziSum = ($depositsJuziSum + $reimburseJuziSum + $cashbookJuziSumCrebit) - ($cashbookJuziSumDebit + $disburseJuziSum + $equityJournalJuziSum);
        /**
        ** Juzi Before Yesterday
        **/


        /**
        ** Yesterday Day before today ie yesterday for opening balance purposes.
        **/
        //cashbook account operations that happened jana.
        /*...*/
        $cashbookYesterday      = Saving::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->get();

        //display deposits that were done yesterday.
        $depositsYesterday      = Account::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->get();

        //display all disbursements that were done yesterday.
        $disburseYesterday      = Disbursement::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->get();

        //display all reimbursements/installments that were done yesterday.
        $reimburseYesterday     = Installment::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->get();
        
        //get the journal plus its data.
        $equityJournalYesterday = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->get();
        /*...*/

        //get the cashbook monies debit
        $cashbookYesterdaySumDebit   = Saving::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->where('action', '=', 'debit')->sum('debit');

        //get the cashbook monies credit
        $cashbookYesterdaySumCredit  = Saving::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->where('action', '=', 'credit')->sum('credit');
       
        //sum up all the deposits
        $depositsYesterdaySum = Account::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->sum('money');     

        //sum up all the disbursed money
        $disburseYesterdaySum  = Disbursement::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->sum('disburseMoney');

        //sum up all the reimbursed money
        $reimburseYesterdaySum = Installment::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->sum('installment');

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yestardayStart, $yestardayEnd])->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yestardayStart, $yestardayEnd])->sum('overpay');
        
        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yestardayStart, $yestardayEnd])->sum('overpay');


        //get the total expense.
        $equityJournalYesterdaySum = $actualFigureEquity + $overpayEquity;

        //get the day before yesterday's closing balance.
        $closingBalanceYesterday = ($closingBalanceJuziSum + $depositsYesterdaySum + $reimburseYesterdaySum + $cashbookYesterdaySumCredit) - ($disburseYesterdaySum + $cashbookYesterdaySumDebit + $equityJournalYesterdaySum);
        /**
        ** Yesterday before yesterday for opening balance purposes.
        **/

        /**
        ** Today.
        **/
        //cashbook account operations that happened jana.
        $cashbookToday  = Saving::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->get();

        //display deposits that were done yesterday.
        $depositsToday  = Account::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->get();

        //display all disbursements that were done yesterday.
        $disburseToday  = Disbursement::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->get();

        //display all reimbursements/installments that were done yesterday.
        $reimburseToday = Installment::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->get();

        //get the journal plus its data.
        $equityJournalToday   = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->get();

        /*...*/
        //get the cashbook monies debit
        $cashbookSumTodayDebit  = Saving::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->where('action', '=', 'debit')->sum('debit');

        //get the cashbook monies credit
        $cashbookSumTodayCredit  = Saving::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->where('action', '=', 'credit')->sum('credit');

        //sum up all the deposits
        $depositsSumToday  = Account::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->sum('money');

        //sum up all the disbursed money
        $disburseSumToday  = Disbursement::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->sum('disburseMoney');

        //sum up all the reimbursed money
        $reimburseSumToday = Installment::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->sum('installment');

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$TodayStart, $TodayEnd])->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$TodayStart, $TodayEnd])->sum('overpay');
    
        //get the total expense.
        $equitySumJournalToday = $actualFigureEquity + $overpayEquity;

        //get the cashbook sum today.
        $cashbookSumToday = $cashbookSumTodayCredit + $cashbookSumTodayDebit;

        //we need to get the closing balance of yesterday.
        $closingBalanceToday = ($closingBalanceYesterday + $depositsSumToday + $reimburseSumToday + $cashbookSumTodayCredit) - ($disburseSumToday + $cashbookSumTodayDebit + $equitySumJournalToday);

        return View('auth.todayBalance', compact('equityJournalToday', 'equitySumJournalToday', 'TodayEnd', 'TodayStart', 'closingBalanceYesterday', 'closingBalanceToday', 'cashbookSumToday', 'depositsSumToday', 'reimburseSumToday', 'disburseSumToday', 'cashbookToday', 'depositsToday', 'disburseToday', 'reimburseToday'))
            ->with('title', $title);
    }

    /**
    ** Balances Yesterday.
    **/
    public function pdfYesterdayBalance() {

        $title = 'PDF Yesterday Balances.';

        //grab yesterday's timelines.
        //start of yesterday ie 00:00:00
        $yesterdayStart = Carbon::yesterday('Africa/Nairobi')->startOfDay();

        //end of yesterday ie 23:59:59
        $yesterdayEnd   = Carbon::yesterday('Africa/Nairobi')->endOfDay();

        //day before yesterday begining of the day
        $minusonedaystart = Carbon::yesterday('Africa/Nairobi')->startOfDay()->subDays(1)->startOfDay();

        //day before yesterday end of the day
        $minusonedayend   = Carbon::yesterday('Africa/Nairobi')->endOfDay()->subDays(1)->endOfDay();


        /**
        ** Day before yesterday for opening balance purposes.
        **/
        //cashbook account operations that happened jana.
        $cashbookBeforeYesterday  = Saving::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->get();

        //get the cashbook monies
        $cashbookBeforeSumYesterday  = Saving::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->sum('debit');

        //display deposits that were done yesterday.
        $depositsBeforeYesterday  = Account::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->get();

        //sum up all the deposits
        $depositsBeforeSumYesterday  = Account::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->sum('money');

        //display all disbursements that were done yesterday.
        $disburseBeforeYesterday  = Disbursement::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->get();

        //sum up all the disbursed money
        $disburseBeforeSumYesterday  = Disbursement::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->sum('disburseMoney');
        
        //display all reimbursements/installments that were done yesterday.
        $reimburseBeforeYesterday = Installment::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->get();

        //sum up all the reimbursed money
        $reimburseBeforeSumYesterday = Installment::whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->sum('installment');

        //get the journal plus its data.
        $equityJournalBeforeYesterday   = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$minusonedaystart, $minusonedayend])->orderBy('created_at', 'desc')->get();

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$minusonedaystart, $minusonedayend])->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$minusonedaystart, $minusonedayend])->sum('overpay');
        
        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$minusonedaystart, $minusonedayend])->sum('overpay');

        //get the total expense.
        $equitySumJournalBeforeYesterday = $actualFigureEquity + $overpayEquity;

        //get the day before yesterday's closing balance.
        $closingBalanceBeforeYesterday = ($depositsBeforeSumYesterday + $reimburseBeforeSumYesterday) - ($cashbookBeforeSumYesterday + $disburseBeforeSumYesterday + $equitySumJournalBeforeYesterday);
        /**
        ** Day before yesterday for opening balance purposes.
        **/

        //cashbook account operations that happened jana.
        $cashbookYesterday  = Saving::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->get();

        //get the cashbook monies
        $cashbookSumYesterday  = Saving::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->sum('debit');

        //display deposits that were done yesterday.
        $depositsYesterday  = Account::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->get();

        //sum up all the deposits
        $depositsSumYesterday  = Account::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->sum('money');

        //display all disbursements that were done yesterday.
        $disburseYesterday  = Disbursement::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->get();
        
        //sum up all the disbursed money
        $disburseSumYesterday  = Disbursement::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->sum('disburseMoney');

        //display all reimbursements/installments that were done yesterday.
        $reimburseYesterday = Installment::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->get();

        //sum up all the reimbursed money
        $reimburseSumYesterday = Installment::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->sum('installment');

        //get the journal plus its data.
        $equityJournalYesterday   = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->orderBy('created_at', 'desc')->get();

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->sum('overpay');
        
        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->sum('overpay');

        //get the total expense.
        $equitySumJournalYesterday = $actualFigureEquity + $overpayEquity;

        //we need to get the closing balance of yesterday.
        $closingBalanceYesterday   = ($closingBalanceBeforeYesterday + $depositsSumYesterday + $reimburseSumYesterday) - ($cashbookSumYesterday + $disburseSumYesterday + $equitySumJournalYesterday);

        $pdf = PDF::loadView('pdf.yesterdayBalancePDF', compact('equitySumJournalYesterday', 'equityJournalYesterday', 'minusonedaystart', 'yesterdayEnd', 'yesterdayStart', 'closingBalanceBeforeYesterday', 'closingBalanceYesterday', 'cashbookSumYesterday', 'depositsSumYesterday', 'reimburseSumYesterday', 'disburseSumYesterday', 'cashbookYesterday', 'depositsYesterday', 'disburseYesterday', 'reimburseYesterday'))->setPaper('a4', 'landscape');

        return $pdf->stream('Yesterday Balance.pdf');
    }

    /**
    ** Balances Today.
    **/
    public function pdfTodayBalance() {

        $title = 'PDF Today Balances.';

        //grab today's timelines.
        //start of today ie 00:00:00
        $TodayStart = Carbon::today('Africa/Nairobi')->startOfDay();

        //end of today ie 23:59:59
        $TodayEnd   = Carbon::today('Africa/Nairobi')->endOfDay();

        //day before today begining of the day
        $yestardayStart = Carbon::today('Africa/Nairobi')->startOfDay()->subDays(1)->startOfDay();

        //day before today end of the day
        $yestardayEnd   = Carbon::today('Africa/Nairobi')->endOfDay()->subDays(1)->endOfDay();

        $juziStart = Carbon::today('Africa/Nairobi')->startOfDay()->subDays(2)->startOfDay();

        //day before yesterday end of the day
        $juziEnd   = Carbon::today('Africa/Nairobi')->endOfDay()->subDays(2)->endOfDay();

        /**
        ** Juzi Before Yesterday
        **/
        //day before yesterday begining of the day

        //get the cashbook monies
        $cashbookJuziSum  = Saving::whereBetween('created_at', [$juziStart, $juziEnd])->orderBy('created_at', 'desc')->sum('debit');

        //sum up all the deposits
        $depositsJuziSum  = Account::whereBetween('created_at', [$juziStart, $juziEnd])->orderBy('created_at', 'desc')->sum('money');

        //sum up all the disbursed money
        $disburseJuziSum  = Disbursement::whereBetween('created_at', [$juziStart, $juziEnd])->orderBy('created_at', 'desc')->sum('disburseMoney');

        //sum up all the reimbursed money
        $reimburseJuziSum = Installment::whereBetween('created_at', [$juziStart, $juziEnd])->orderBy('created_at', 'desc')->sum('installment');

        //get the journal plus its data.
        //$equityJournalBefore = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$minustwodaystart, $minustwodayend])->orderBy('created_at', 'desc')->get();

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$juziStart, $juziEnd])->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$juziStart, $juziEnd])->sum('overpay');
        
        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$juziStart, $juziEnd])->sum('overpay');

        //get the total expense.
        $equityJournalJuziSum = $actualFigureEquity + $overpayEquity;

        //get the day before yesterday's closing balance.
        $closingBalanceJuziSum = ($depositsJuziSum + $reimburseJuziSum) - ($cashbookJuziSum + $disburseJuziSum + $equityJournalJuziSum);
        /**
        ** Juzi Before Yesterday
        **/


        /**
        ** Yesterday Day before today ie yesterday for opening balance purposes.
        **/
        //cashbook account operations that happened jana.
        /*...*/
        $cashbookYesterday      = Saving::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->get();

        //display deposits that were done yesterday.
        $depositsYesterday      = Account::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->get();

        //display all disbursements that were done yesterday.
        $disburseYesterday      = Disbursement::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->get();

        //display all reimbursements/installments that were done yesterday.
        $reimburseYesterday     = Installment::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->get();
        
        //get the journal plus its data.
        $equityJournalYesterday = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->get();
        /*...*/

        //get the cashbook monies
        $cashbookYesterdaySum  = Saving::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->sum('debit');
       
        //sum up all the deposits
        $depositsYesterdaySum = Account::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->sum('money');     

        //sum up all the disbursed money
        $disburseYesterdaySum  = Disbursement::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->sum('disburseMoney');

        //sum up all the reimbursed money
        $reimburseYesterdaySum = Installment::whereBetween('created_at', [$yestardayStart, $yestardayEnd])->orderBy('created_at', 'desc')->sum('installment');

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yestardayStart, $yestardayEnd])->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yestardayStart, $yestardayEnd])->sum('overpay');
        
        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$yestardayStart, $yestardayEnd])->sum('overpay');


        //get the total expense.
        $equityJournalYesterdaySum = $actualFigureEquity + $overpayEquity;

        //get the day before yesterday's closing balance.
        $closingBalanceYesterday = ($closingBalanceJuziSum + $depositsYesterdaySum + $reimburseYesterdaySum) - ($disburseYesterdaySum + $cashbookYesterdaySum + $equityJournalYesterdaySum);
        /**
        ** Yesterday before yesterday for opening balance purposes.
        **/

        /**
        ** Today.
        **/
        //cashbook account operations that happened jana.
        $cashbookToday  = Saving::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->get();

        //display deposits that were done yesterday.
        $depositsToday  = Account::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->get();

        //display all disbursements that were done yesterday.
        $disburseToday  = Disbursement::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->get();

        //display all reimbursements/installments that were done yesterday.
        $reimburseToday = Installment::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->get();

        //get the journal plus its data.
        $equityJournalToday   = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->get();

        /*...*/
        //get the cashbook monies
        $cashbookSumToday  = Saving::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->sum('debit');

        //sum up all the deposits
        $depositsSumToday  = Account::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->sum('money');

        //sum up all the disbursed money
        $disburseSumToday  = Disbursement::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->sum('disburseMoney');

        //sum up all the reimbursed money
        $reimburseSumToday = Installment::whereBetween('created_at', [$TodayStart, $TodayEnd])->orderBy('created_at', 'desc')->sum('installment');

        //get actual figure.
        $actualFigureEquity = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$TodayStart, $TodayEnd])->sum('actualFigure');

        //get overpay.
        $overpayEquity      = Journal::where('bank', '=', 'Equity Bank')->whereBetween('created_at', [$TodayStart, $TodayEnd])->sum('overpay');
    
        //get the total expense.
        $equitySumJournalToday = $actualFigureEquity + $overpayEquity;


        //we need to get the closing balance of yesterday.
        $closingBalanceToday = ($closingBalanceYesterday + $depositsSumToday + $reimburseSumToday) - ($disburseSumToday + $cashbookSumToday + $equitySumJournalToday);

        $pdf = PDF::loadView('pdf.todayBalancePDF', compact('equityJournalToday', 'equitySumJournalToday', 'TodayEnd', 'TodayStart', 'closingBalanceYesterday', 'closingBalanceToday', 'cashbookSumToday', 'depositsSumToday', 'reimburseSumToday', 'disburseSumToday', 'cashbookToday', 'depositsToday', 'disburseToday', 'reimburseToday'))->setPaper('a4', 'landscape');

        return $pdf->stream('Today Balance.pdf');
    }

    /**
    ** Journals.
    **/
    public function journals() {

        $title = 'Journals';

        $journals = Journal::orderBy('created_at', 'desc')->get();

        return View('auth.journals', compact('journals'))
            ->with('title', $title);
    }

    /**
    ** Create Journals.
    **/
    public function createJournals() {

        $title = 'Create Journals';

        //gain access to chart of accounts.
        $charts = DB::table('charts')->where('accountName', '!=', 'Equity Bank')
            ->where('accountName', '!=', 'Co-op Bank')
            ->where('accountName', '!=', 'Petty Cash')
            ->where('accountName', '!=', 'Co-op Opening Balance')
            ->where('accountName', '!=', 'Equity Opening Balance')
            ->where('accountName', '!=', 'Petty Cash Opening Balance')->get();

        $select = [];

        foreach($charts as $chart){

            $select[$chart->accountName] = $chart->accountName;
        }

        return View('auth.createJournals', compact('select', 'charts'))
            ->with('title', $title);
    }

    /**
    ** Store Journals.
    **/
    public function storeJournals(Request $request) {

        //valdiation.
        $this->validate($request, [

            'details'      => 'required',
            'accountName'  => 'required',
            'actualFigure' => 'required',
            'overpay'      => 'required',
            'bank'         => 'required',
            'duration'     => 'required'
        ]);

        if ($request->fails) {
            
            return redirect()->route('createJournals')
                ->withInput()
                ->withErrors($request);
        }
        else {

            //get the data.
            $details      = $request->details;
            $accountName  = $request->accountName;
            $actualFigure = $request->actualFigure;
            $overpay      = $request->overpay;
            $bank         = $request->bank;
            $duration     = $request->duration;

            //ensure that we are covering both sectors.
            if ($overpay == 0 && $duration == 0) {

                //we need to credit the bank with the correct monies.
                $credit = Chart::where('accountName', '=', $bank)->pluck('money');

                //deduct the money from the bank
                $deduct = $credit - $actualFigure;

                $data = [

                    'money' => $deduct
                ];

                //update the bank
                Chart::where('accountName', '=', $bank)->update($data);

                //we need to increment the detail of the account in the chart of accounts.
                Chart::where('accountName', '=', $accountName)->increment('detail', $actualFigure);
                
                //this means that its a single and final transaction.
                $transact = Auth::user()->journals()->create([

                    'details'      => $details,
                    'accountName'  => $accountName,
                    'actualFigure' => $actualFigure,
                    'overpay'      => $overpay,
                    'bank'         => $bank,
                    'duration'     => $duration,
                ]);

                //re route accordingly.
                return redirect()->route('journals')
                    ->with('global', '<p style="font:20px book antiqua; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-info alert-dismissible" role="alert">' . 'Journal Passed Successfully.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
            }
            else if ($overpay > 0 && $duration > 0 && $actualFigure > 0) {
                
                //we need to negate the overpay value.
                $negOverpay = abs($overpay);

                //we need to credit the bank with the correct monies.
                $credit = Chart::where('accountName', '=', $bank)->pluck('money');

                $expense = $actualFigure + $overpay;

                //deduct the money from the bank
                $deduct = $credit - $expense;

                $data = [

                    'money' => $deduct
                ];

                //update the bank
                Chart::where('accountName', '=', $bank)->update($data);

                //we need to increment the detail of the account in the chart of accounts.
                Chart::where('accountName', '=', $accountName)->increment('detail', $expense);
                
                //this means that its a single and final transaction.
                $transact = Auth::user()->journals()->create([

                    'details'      => $details,
                    'accountName'  => $accountName,
                    'actualFigure' => $actualFigure,
                    'overpay'      => $negOverpay,
                    'bank'         => $bank,
                    'duration'     => $duration,
                ]);

                //re route accordingly.
                return redirect()->route('journals')
                    ->with('global', '<p style="font:20px book antiqua; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-info alert-dismissible" role="alert">' . 'Journal Passed Successfully.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
            }
            else {

                //re route accordingly.
                return redirect()->route('createJournals')
                    ->with('global', '<p style="font:20px book antiqua; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-danger alert-dismissible" role="alert">' . 'Journal Wasn\'t Successfully Passed.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
            }            
        }
    }

    /**
    ** Edit Journals.
    **/
    public function editJournals(Request $request, $id) {

        //title
        $title = 'Edit Journals';

        //get the journals
        $journals = Auth::user()->journals()->orderBy('created_at', 'desc')->get();

        return View('auth.editJournals', compact('journals'))
            ->with('title', $title);
    }

    /**
    ** Update Journals.
    **/
    public function updateJournal(Request $request, $id) {

        //validation.
        $this->validate($request, [

            'id'           => 'required',
            'details'      => 'required',
            'accountName'  => 'required',
            'actualFigure' => 'required',
            'overpay'      => 'required',
            'duration'     => 'required',
        ]);

        if ($request->fails) {
            
            return response()->json(['error' => 'Validation Failed.'], 200);
        }
        else {

            $id           = $request->id;
            $details      = $request->details;
            $accountName  = $request->accountName;
            $actualFigure = $request->actualFigure;
            $overpay      = $request->overpay;
            $duration     = $request->duration;

            //get the actual values from our table.
            $journal = Journal::find($id);

            $detailsjournal      = $journal->details;
            $accountNamejournal  = $journal->accountName;
            $actualFigurejournal = $journal->actualFigure;
            $overpayjournal      = $journal->overpay;
            $durationjournal     = $journal->duration;

            if ($details == $detailsjournal && $accountName == $accountNamejournal && $actualFigure == $actualFigurejournal && $overpay == $overpayjournal && $duration == $durationjournal) {
                
                //no changes effected.
                return response()->json(['response' => 'NO Changes Effected at This Time.'], 200);
            }
            else if ($details != $detailsjournal) {
                
                //means that details has been changed.
                $datadetails = [

                    'details' => $details
                ];

                $journal->update($datadetails);

                return response()->json(['response' => 'Details Changed Successfully.'], 200);
            }
            else if ($accountName != $accountNamejournal) {
                
                //means that account name has been changed.
                return response()->json(['response' => 'Account Name Changed Successfully.'], 200);
            }
            else if ($actualFigure != $actualFigurejournal) {
                
                //means that actual figure has been changed.

                //first change the journal.
                $dataactualfigure = [

                    'actualFigure' => $actualFigure
                ];

                $journal->update($dataactualfigure);

                //secondly, update the bank and detail responsible.
                $equityBank  = Chart::where('accountName', '=', 'Equity Bank');

                $chartDetail = Chart::where('accountName', '=', $accountName);

                //we need to know if its an increment or decrement operation.
                if ($actualFigurejournal > $actualFigure) {
                    
                    $journalResult = $actualFigurejournal - $actualFigure;

                    //therefore we decrement the equity banks cash.
                    $equityBank->decrement('money', $journalResult);

                    //we also decrement the detail cash from the charts table.
                    $chartDetail->decrement('detail', $journalResult);
                }
                else if ($actualFigurejournal < $actualFigure) {

                    $journalResult = $actualFigure - $actualFigurejournal;

                    //therefore we increment the equity banks cash.
                    $equityBank->increment('money', $journalResult);

                    //we also increment the detail cash from the charts table.
                    $chartDetail->increment('detail', $journalResult);
                }

                return response()->json(['response' => 'Actual Figure Changed Successfully.'], 200);
            }
            else if ($overpay != $overpayjournal) {
                
                //means that overpay has been changed.

                //first change the journal.
                $dataoverpay = [

                    'overpay' => $overpay
                ];

                $journal->update($dataoverpay);

                //secondly, update the bank and detail responsible.
                $equityBank  = Chart::where('accountName', '=', 'Equity Bank');

                $chartDetail = Chart::where('accountName', '=', $accountName);

                //we need to know if its an increment or decrement operation.
                if ($overpayjournal > $overpay) {
                    
                    $journalResult = $overpayjournal - $overpay;

                    //therefore we decrement the equity banks cash.
                    $equityBank->decrement('money', $journalResult);

                    //we also decrement the detail cash from the charts table.
                    $chartDetail->decrement('detail', $journalResult);
                }
                else if ($overpayjournal < $overpay) {

                    $journalResult = $overpay - $overpayjournal;

                    //therefore we increment the equity banks cash.
                    $equityBank->increment('money', $journalResult);

                    //we also increment the detail cash from the charts table.
                    $chartDetail->increment('detail', $journalResult);
                }
                return response()->json(['response' => 'Overpay Changed Successfully.'], 200);
            }
            else if ($duration != $durationjournal) {
                
                //means that duration has been changed.
                $dataduration = [

                    'duration' => $duration
                ];

                $journal->update($dataduration);

                return response()->json(['response' => 'Duration Changed Successfully.'], 200);
            }
            else {

                //means that non is applicable.
                return response()->json(['response' => 'NOT Applicable.'], 200);
            }
        }


        //find the user by id.
        
    }
    /**
    ** Remove the specified resource from storage.
    **/
    public function destroy($id)
    {
        //
    }
}
