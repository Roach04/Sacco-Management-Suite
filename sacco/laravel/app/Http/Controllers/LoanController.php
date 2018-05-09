<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use View;
use App\User;
use App\Member;
use App\Loan;
use App\Account;
use App\Installment;
use App\Chart;
use App\Disbursement;
use Auth;
use DB;

class LoanController extends Controller
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

        //get today.
        $today = Carbon::now();

        //get all the loans.
        $loans = Loan::where('state', '=', 2)->get();    
                 
        /* Update when the last day of loan reimbursements arrives. */


        /* Monitoring whether any member has defaulted in loan reimbursements.*/

        //we therefore need to gain access to member's ids for addDays() updates.
        $members = Member::where('loanStatus', '=', 1)->get();
        
        
        /* Monitoring whether the grace period is over*/  

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
    }

    /**
    ** Genesis.
    */
    public function index()
    {
        //get all the loans.
        $title = 'Member Loans.';

        return View('auth.members.loan.loans')
            ->with('title', $title);
    }

    /**
    ** Loan Calculator.
    **/
    public function calculator() {

        $title = 'Loan Calculator.';

        return View('auth.members.loan.loanCalculator')
            ->with('title', $title);
    }

    /**
    ** Create Loans/
    **/
    public function create($id)
    {
        //get the title.
        $title = 'Create Loans.';

        //get the member via id.
        $member = Member::find($id);

        return View('auth.members.loan.createLoans', compact('member'))
            ->with('title', $title);
    }

    /**
    ** Store new Loans.
    **/
    public function store(Request $request)
    {
        //validations.
        $this->validate($request, [
            'loan'               => 'required',
            'loanDuration'       => 'required',
            'guaranteeOne'       => 'required',
            'guaranteeTwo'       => 'required',
            'guaranteeThree'     => 'required',
            'moneyOne'           => 'required',
            'moneyTwo'           => 'required',
            'moneyThree'         => 'required',
            'modeOfPayment'      => 'required',
            'monthlyInstallment' => 'required',
            'loanEntity'         => 'required',
            'loanType'           => 'required',
        ]);

        if ($request->fails) {
            
            return response()->json(['error' => 'Something Went Horribly Wrong.']);
        }
        else {

            //get the data from ajax.
            $id                 = $request['id'];
            $loan               = $request['loan'];
            $loanDuration       = $request['loanDuration'];
            $guaranteeOne       = $request['guaranteeOne'];
            $guaranteeTwo       = $request['guaranteeTwo'];
            $guaranteeThree     = $request['guaranteeThree'];
            $moneyOne           = $request['moneyOne'];
            $moneyTwo           = $request['moneyTwo'];
            $moneyThree         = $request['moneyThree'];
            $modeOfPayment      = $request['modeOfPayment'];
            $monthlyInstallment = $request['monthlyInstallment'];
            $loanEntity         = $request['loanEntity'];
            $loanType           = $request['loanType'];

            //find the member by id.
            $member = Member::find($id);

            //ensure that only members whose loans have not exceeded three times thier deposits
            //can apply.
            //take the members total remaining deposits and multiply them by three.
            $totals = $member->totals * 3;

            //get the day the member was created and compare with todays date.
            $thirty = $member->created_at->addMonths(3)->formatlocalized('%a %d %b %y');

            //put all my data into an array.
            $data = [

                'loan'               => $loan,
                'loanDuration'       => $loanDuration,
                'guaranteeOne'       => $guaranteeOne,
                'guaranteeTwo'       => $guaranteeTwo,
                'guaranteeThree'     => $guaranteeThree,
                'moneyOne'           => $moneyOne,
                'moneyTwo'           => $moneyTwo,
                'moneyThree'         => $moneyThree,
                'modeOfPayment'      => $modeOfPayment,
                'monthlyInstallment' => $monthlyInstallment,
                'loanEntity'         => $loanEntity,
                'loanType'           => $loanType,
            ];

            //get today.
            $today  = carbon::now();

            if ($totals >= $loan ) {
                
                //&& $today > $thirty

                //insert the above data into the database.
                $success = $member->loan()->create($data);

                if ($success) {
                    
                    return response()->json(['response' => 'Loan Application Successful.'], 200);
                }
                else {

                    return response()->json(['failure' => 'Loan Application Failed.'], 200);
                }
            }
            else if ($today < $thirty) {
                
                //get the members' details.
                $fname = $member->firstname;

                $lname = $member->lastname;

                return response()->json(['failure' => $fname. ' '.$lname .' Not Qualified For a Loan.'], 200);
            }
            else if($totals < $loan) {

                //get the members' details.
                $fname = $member->firstname;

                $lname = $member->lastname;

                //get the deposits.
                $depos = $member->totals;

                return response()->json(['failure' => $fname. ' '.$lname .' Has Deposits Totaling To KES ' .$depos], 200);
            }   
            else {

                return response()->json(['failure' => 'Loan Application Denied.'], 200);
            }
        }
    }

    /**
    ** Display all the member's loans.
    **/
    public function loansMember($id)
    {
        //get the title.
        $title = 'Member Loans.';

        //get the member via id.
        $member = Member::find($id);

        //get the loan count of this member via id.
        $loan = DB::table('loans')->where('member_id', '=', $id)->count();

        //gain access to all loans.
        //then search if the current member is a guarantor of either to the loans in qn.
        //get the loan of this member via id.
        $loans = Loan::where('member_id', '=', $id)
                ->orWhere('guaranteeOne', '=', $member->accountNumber)
                ->orWhere('guaranteeTwo', '=', $member->accountNumber)
                ->orWhere('guaranteeThree', '=', $member->accountNumber)->get();

        //check the member to assertain how much s/he has in his/her account.
        $cash = DB::table('members')->where('id', '=', $id)->pluck('totals');

        //get the status of the loan belonging to each member.
        $status = DB::table('loans')->where('member_id', '=', $id)->pluck('state');

        //do a summation of all loans where state is active or == 1.
        $activeLoans = $member->loan->sum('amount');

        if ($loan) {        

            //at what point in time was the last update done.
            $record = $member->loan()->latest()->first();
            
            $last   = $record->updated_at->formatLocalized('%a %d %b %y');

            /*//get the loan via id.
            $loanId = $member->loan->id;

            $loan = Loan::find($id);

            //we also need to get to the last made installment from this loan.
            $lastInstallment = $loan->installments->latest()->first();

            dd($lastInstallment);*/

            return View('auth.members.loan.loansMember', compact('activeLoans', 'loans', 'loan', 'last', 'cash', 'member', 'status', 'access'))
            ->with('title', $title);
        }
        else {

            return View('auth.members.loan.loansMember', compact('access', 'member', 'loan', 'cash'))
            ->with('title', $title);
        }             
    }

    /**
    ** Display all the member's loan details.
    **/
    public function show($id)
    {
        //get the title.
        $title = 'Show Loan.';

        //get the member via id.
        $loan = Loan::find($id);

        $contra = $loan->disbursements->count();

        //get all disbursements under this loan.
        $disbursements = DB::table('disbursements')->where('loan_id', '=', $id)->sum('disburseMoney');

        if ($contra > 0) {

            //get today
            $today = Carbon::now();
            
            if ($today <  $loan->created_at->addDays($loan->gracePeriod)) {
                    
                $gracePeriod = $loan->created_at->addDays($loan->gracePeriod)->diffInDays();

                //dd($gracePeriod. ' Grace Period.');
            }
            else if ($today > $loan->created_at->addDays($loan->gracePeriod)) {
                
                $loanAgeing = $loan->created_at->addMonths($loan->loanDuration)->diffInMonths();

                //dd($loanAgeing. ' Loan Ageing.');
            }
        }     

        return View('auth.members.loan.showLoan', compact('loan', 'disbursements'))
        ->with('title', $title);         
    }

    /**
    ** Process the Loan.
    **/
    public function process(Request $request, $id)
    {

        //get the loan
        $loan = Loan::find($id);

        //get the totals of the member applying for the loan.
        $memberTotals = $loan->member->totals;
    
        //get the guarantees from the loans table.
        $guarantOne   = $loan->guaranteeOne;

        $guarantTwo   = $loan->guaranteeTwo;

        $guarantThree = $loan->guaranteeThree;

        //get the moneys guaranteed by the guarantors.
        $moneyOne   = $loan->moneyOne;

        $moneyTwo   = $loan->moneyTwo;

        $moneyThree = $loan->moneyThree;


        //check / search if the above guarantees either have a loan or are guaranteeing someone else.
        $gone   = DB::table('members')->where('accountNumber', '=', $guarantOne)->first();

        $gtwo   = DB::table('members')->where('accountNumber', '=', $guarantTwo)->first();

        $gthree = DB::table('members')->where('accountNumber', '=', $guarantThree)->first();

        //get the id of the gone member.
        $gidOne = $gone->id;

        //get the money of the first guarantee
        $totalOne   = DB::table('members')->where('id', '=', $gidOne)->pluck('totals');

        //get the id of the gtwo member.
        $gidTwo = $gtwo->id;

        //get the money of the second guarantee
        $totalTwo   = DB::table('members')->where('id', '=', $gidTwo)->pluck('totals');

        //get the id of the gthree member.
        $gidThree = $gthree->id;

        //get the money of the third guarantee
        $totalThree = DB::table('members')->where('id', '=', $gidThree)->pluck('totals');

        //give the loan if the above conditions are met.
        //the total amount of guarantors can guarantee the whole loan.
            
        //interest rate to be 10 percent.
        $interestRate = 10/100;

        //calculate the interest
        $interest = $loan->loan * $interestRate;

        //get the total loan i.e. loan plus interest.
        $amount = $loan->loan + $interest;

        //get the percentages of moneys guaranteed by the guarantors.
        $roundOne   = ($moneyOne / $amount) * 100;

            $percentOne = round($roundOne, 1);

        $roundTwo   = ($moneyTwo / $amount) * 100;

            $percentTwo = round($roundTwo, 1);

        $roundThree = ($moneyThree / $amount) * 100;

            $percentThree = round($roundThree, 1);


        //check to establish if all the guarantors have the required money.
        //totals of the guarantors should be more that what these guarantors are guaranteeing.
        if ($totalOne > $moneyOne && $totalTwo > $moneyTwo && $totalThree > $moneyThree) {
            
            //deduct the guaranteed money from the first guarantor.
            $deductOne   = $totalOne   - $moneyOne;

            //deduct the money from the second guarantor.
            $deductTwo   = $totalTwo   - $moneyTwo;

            //deduct the money from the third guarantor.
            $deductThree = $totalThree - $moneyThree;

            /*
            ** ensure a change in the member guaranteeing the loan.
            */
            
            //get the money of the first guarantee
            $memberOne = Member::where('id', '=', $gidOne);

            //get the guarantor money of the specific member.
            $getGuarantCash = Member::where('id', '=', $gidOne)->pluck('guarantorMoney');

            //increment the value of the guarantorMoney
            $guarantCashOne = $getGuarantCash + $moneyOne;

            //get the data and field name into an array for updates.
            $dataOne = [

                'totals'          => $deductOne,
                'guarantorMoney'  => $guarantCashOne,
                'guaranteeStatus' => 1,
            ];

            //update the table.
            $memberOne->update($dataOne);
                                    
            /*
            ** ensure a change in the member guaranteeing the loan.
            */
            
            //get the money of the second guarantee
            $memberTwo = Member::where('id', '=', $gidTwo);

            //get the guarantor money of the specific member.
            $getGuarantCash = Member::where('id', '=', $gidTwo)->pluck('guarantorMoney');

            //increment the value of the guarantorMoney
            $guarantCashTwo = $getGuarantCash + $moneyTwo;


            //get the data and field name into an array for updates.
            $dataTwo = [

                'totals'          => $deductTwo,
                'guarantorMoney'  => $guarantCashTwo,
                'guaranteeStatus' => 1,
            ];

            //update the table.
            $memberTwo->update($dataTwo);
        
            /*
            ** ensure a change in the member guaranteeing the loan.
            */
            
            //get the money of the third guarantee
            $memberThree = Member::where('id', '=', $gidThree);

            //get the guarantor money of the specific member.
            $getGuarantCash = Member::where('id', '=', $gidThree)->pluck('guarantorMoney');

            //increment the value of the guarantorMoney
            $guarantCashThree = $getGuarantCash + $moneyThree;

            //get the data and field name into an array for updates.
            $dataThree = [

                'totals'          => $deductThree,
                'guarantorMoney'  => $guarantCashThree,
                'guaranteeStatus' => 1,
            ];

            //update the table.
            $memberThree->update($dataThree);

            //get the loan.
            $loann = Loan::where('id', '=', $id);

            //change the loan's particulars.
            //change the state to 1 and place in the real loan
            $change = [

                'interest'     => $interest,
                'amount'       => $amount,
                'percentOne'   => $percentOne,
                'percentTwo'   => $percentTwo,
                'percentThree' => $percentThree,
                'state'        => 1
            ];

            //update the loans table that a loan has been given.
            $loann->update($change);

            /*
            ** ensure the member getting the loan is activated.
            */
            
            //update the loan status of the member getting the loan.
            $memberLoan = $loan->member->id;

            //update the totals of the member taking the loan.
            $deductMemberTotals = $memberTotals - $amount;

            //get the data and field name into an array for updates.
            $dataLoan = [

                'loanStatus' => 1,
                'totals'     => $deductMemberTotals
            ];

            //update the table.
            $loan->member->update($dataLoan);

            //get the firstname and lastname of the member getting the loan.
            $fname = $loan->member->firstname;

            $lname = $loan->member->lastname;

            return redirect()->route('loansMember', $loan->member->id)
            -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-info alert-dismissible" role="alert">'. $fname .' '.$lname .'\'s' .' Loan Approval Successful.'. '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
        }
        else if($totalOne < $moneyOne){

            //get the details of moneyOne.
            $fnameOne = $gone->firstname;

            $lnameOne = $gone->lastname;

            return redirect()->route('loansMember', $loan->member->id)
            -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-danger alert-dismissible" role="alert">'. $fnameOne .' '.$lnameOne .'\'s' . ' Account NOT Enough To Guarantee the Loan.'. '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
        }
        else if($totalTwo < $moneyTwo){

            //get the details of moneyOne.
            $fnameTwo = $gtwo->firstname;
            
            $lnameTwo = $gtwo->lastname;

            return redirect()->route('loansMember', $loan->member->id)
            -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-danger alert-dismissible" role="alert">'. $fnameTwo .' '.$lnameTwo .'\'s' . ' Account NOT Enough To Guarantee the Loan.'. '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
        }
        else if($totalThree < $moneyThree){

            //get the details of moneyOne.
            $fnameThree = $gthree->firstname;
            
            $lnameThree = $gthree->lastname;

            return redirect()->route('loansMember', $loan->member->id)
            -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-danger alert-dismissible" role="alert">'. $fnameThree .' '.$lnameThree .'\'s' . ' Account NOT Enough To Guarantee the Loan.'. '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
        }
        else {

            return redirect()->route('memberLoans')
            -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-danger alert-dismissible" role="alert"> Loan NOT Applicable. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
        }      
    }

    /**
    ** Create Loan Disbursement.
    **/
    public function createDisbursement($id) {

        $title = 'Create Loan Disbursement.';

        //get loans via thier ids.
        $loan = Loan::find($id);

        //get all disbursements under this loan.
        $disbursements = DB::table('disbursements')->where('loan_id', '=', $id)->sum('disburseMoney');

        //get equity bank.
        $equityAccount = Chart::where('accountName', '=', 'Equity Bank')->pluck('money');

        return View('auth.members.loan.createLoanDisburse', compact('loan', 'equityAccount', 'disbursements'))
            ->with('title', $title);
    }

    /**
    ** Loan Disbursement.
    **/
    public function loanDisburse($id) {

        $title = 'Loan Disbursement.';

        //get loans via thier ids.
        $loan = Loan::find($id);

        //get all disbursements summations under this loan.
        $disbursements = DB::table('disbursements')->where('loan_id', '=', $id)->sum('disburseMoney');

        //get all disbursements under the said loan
        $disburses = DB::table('disbursements')->where('loan_id', '=', $id)->get();

        //get equity bank.
        $equityAccount = Chart::where('accountName', '=', 'Equity Bank')->pluck('money');

        return View('auth.members.loan.loanDisburse', compact('disburses', 'loan', 'equityAccount', 'disbursements'))
            ->with('title', $title);
    }

    /**
    ** Store Loan Disbursement.
    **/
    public function storeDisbursement(Request $request, $id) {

        //validation.
        $this->validate($request,[

            'disburseMoney' => 'required',
            'chequeNumber'  => 'required',
            'firstname'     => 'required',
            'lastname'      => 'required',
            'accountNumber' => 'required',
            'equityBank'    => 'required',
        ]);

        if ($request->fails) {
            
            return redirect()->route('loanDisburse', $id)
                    ->withErrors($request)
                    ->withInput();
        }
        else {

            $disburseMoney = $request['disburseMoney'];
            $chequeNumber  = $request['chequeNumber'];
            $firstname     = $request['firstname'];
            $lastname      = $request['lastname'];
            $accountNumber = $request['accountNumber'];
            $equityBank    = $request['equityBank'];

            //get the loan.
            $loan = Loan::find($id);

            $loanDuration = $loan->loanDuration;

            $gracePeriod  = 30;

            //create the data.
            $create = $loan->disbursements()->create([

                'disburseMoney' => $disburseMoney,
                'chequeNumber'  => $chequeNumber,
                'firstname'     => $firstname,
                'lastname'      => $lastname,
                'accountNumber' => $accountNumber,
                'bank'          => $equityBank,
                'loanDuration'  => $loanDuration,
                'gracePeriod'   => $gracePeriod,
                'status'        => 1
            ]);

            if ($create) {

                //we need to deduct the money from the said bank.
                $bank = Chart::where('accountName', '=', 'Equity Bank')->pluck('money');

                $deduct = $bank - $disburseMoney;

                $data = [
                    
                    'money' => $deduct 
                ];

                //commit the transaction above.
                DB::table('charts')->where('accountName', '=', 'Equity Bank')->update($data);

                //we also need to update the grace period in the loans table.
                $dataLoanPeriod =  [

                    'gracePeriod' => $gracePeriod
                ];

                $loan->update($dataLoanPeriod);
                
                return redirect()->route('showLoan', $loan->id)
                    -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-info alert-dismissible" role="alert">'. $firstname .' '.$lastname .'\'s' .' Loan Disbursement Successful.'. '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
            }
            else {

                return redirect()->route('loanDisburse', $loan->id)
                    -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-info alert-dismissible" role="alert">'. $firstname .' '.$lastname .'\'s' .' Loan Disbursement Successful.'. '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
            }

            return $equityBank;
        }
    }

    /**
    ** Edit Loan Disbursement.
    **/
    public function editDisburse($id) {

        $title = 'Edit Disbursements.';

        $loan = Loan::find($id);

        //get all disbursements summations under this loan.
        $disbursements = DB::table('disbursements')->where('loan_id', '=', $id)->sum('disburseMoney');

        //get all disbursements under the said loan
        $disburses = DB::table('disbursements')->where('loan_id', '=', $id)->get();

        //get equity bank.
        $equityAccount = Chart::where('accountName', '=', 'Equity Bank')->pluck('money');

        return View('auth.members.loan.editDisburse', compact('loan', 'disbursements', 'disburses', 'equityAccount'))
            ->with('title', $title);
    }

    /**
    ** Update Loan Disbursement.
    **/
    public function updateDisbursement(Request $request, $id) {

        $this->validate($request, [

            'id'            => 'required',
            'disburseMoney' => 'required',
            'chequeNumber'  => 'required',
            'loanDuration'  => 'required',
        ]);

        if ($request->fails) {
            
            return response()->json(['error', 'Validation Failure'], 200);
        }
        else {

            //get the data from our modal via ajax.
            $id            = $request->id;
            $disburseMoney = $request->disburseMoney;
            $chequeNumber  = $request->chequeNumber;
            $loanDuration  = $request->loanDuration;

            //we need another layer of validation ie we need to check if the data has been changed at all.
            $disburse = Disbursement::find($id);

            $disburseMoneyvalid = $disburse->disburseMoney;
            $chequeNumbervalid  = $disburse->chequeNumber;
            $loanDurationvalid  = $disburse->loanDuration;

            if ($disburseMoney == $disburseMoneyvalid && $chequeNumber == $chequeNumbervalid && $loanDuration == $loanDurationvalid) {
                
                //no changes effected.
                return response()->json(['response' => 'NO Changes Effected at This Time.'], 200);
            }
            else if($disburseMoney != $disburseMoneyvalid) {

                //means that the disbursed money has been changed.
                $datadisburseMoney = [

                    'disburseMoney' => $disburseMoney
                ];

                $disburse->update($datadisburseMoney);

                //we also need to update the bank.
                $equityBank = Chart::where('accountName', '=', 'Equity Bank');

                //we need to know if its an increment or decrement operation.
                if ($disburseMoneyvalid > $disburseMoney) {
                    
                    $disburseResult = $disburseMoneyvalid - $disburseMoney;

                    //therefore we increment the equity banks cash.
                    $equityBank->decrement('money', $disburseResult);
                }
                else if ($disburseMoneyvalid < $disburseMoney) {

                    $disburseResult = $disburseMoney - $disburseMoneyvalid;

                    //therefore we increment the equity banks cash.
                    $equityBank->increment('money', $disburseResult);
                }
                return response()->json(['response' => 'Disburse Money changed Successfully.'], 200);
            }
            else if ($chequeNumber != $chequeNumbervalid) {
                
                //means that the cheque number has been changed.
                //there are no thorough effects on the system.
                $datachequeNumber = [

                    'chequeNumber' => $chequeNumber
                ];

                $disburse->update($datachequeNumber);

                return response()->json(['response' => 'Cheque Number changed Successfully.'], 200);
            }
            else if ($loanDuration != $loanDurationvalid) {
                
                //this means that the loan duration has changed.
                $dataloanDuration = [

                    'loanDuration' => $loanDuration
                ];

                $disburse->update($dataloanDuration);

                //we also need to update the loans table for the repective loan.
                $disburse->loan->update($dataloanDuration);

                return response()->json(['response' => 'Loan Duration changed Successfully.'], 200);
            }
            else {

                return response()->json(['failure' => 'NOT Applicable.'], 200);
            }
        }
    } 

    /**
    ** access all approved loans.
    **/
    public function approved() {

        $title = 'Approved Loans.';

        //get all active loans.
        $approvedLoans = Loan::where('state', '=', 1)->orderBy('created_at', 'desc')->get();        

        return View('auth.members.loan.approvedLoans', compact('approvedLoans'))
            ->with('title', $title);        
    }

    /**
    ** Loan Defaulters.
    **/
    public function defaulters() {

        $title = 'Loan Defaulters.';

        //get all insatallments.
        $defaulters = Loan::where('state', '=', 3)->orderBy('created_at', 'desc')->get();

        return View('auth.members.loan.defaulters', compact('defaulters'))
            ->with('title', $title);
    }

    /**
    ** Update the Member's loan details.
    **/
    public function update(Request $request, $id)
    {
        //first validate all the inputs.
        $this->validate($request, [
            'loan'               => 'required',
            'guaranteeOne'       => 'required',
            'guaranteeTwo'       => 'required',
            'guaranteeThree'     => 'required',
            'loanDuration'       => 'required',
            'gracePeriod'        => 'required',
            'modeOfPayment'      => 'required',
            'checkNumber'        => 'required',
            'loanEntity'         => 'required',
            'loanType'           => 'required',
            'monthlyInstallment' => 'required'
            ]);

        if ($request->fails) {
            
            return redirect()->route('showLoan', $id)
                ->withErrors($request)
                ->withInput();
        }
        else {

            //get the firstname.
            $firstname = $request->firstname;

            //get the lastname.
            $lastname  = $request->lastname;

            $data = [

                'loan'               => $request->loan,
                'guaranteeOne'       => $request->guaranteeOne,
                'guaranteeTwo'       => $request->guaranteeTwo,
                'guaranteeThree'     => $request->guaranteeThree,
                'loanDuration'       => $request->loanDuration,
                'gracePeriod'        => $request->gracePeriod,
                'modeOfPayment'      => $request->modeOfPayment,
                'checkNumber'        => $request->checkNumber,
                'loanEntity'         => $request->loanEntity,
                'loanType'           => $request->loanType,
                'monthlyInstallment' => $request->monthlyInstallment
            ];

            //find the member via id.
            $loan = Loan::find($id);

            //update the data and re route accordingly.
            $save = $loan->update($data);

            if ($save) {
                
                return redirect()->route('showLoan', $id)
                -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-warning alert-dismissible" role="alert">' . $firstname .' '. $lastname. ' ' .'Loan Updates Succefully Done.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
            }
            else{

                return redirect()->route('showLoan', $id)
                -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-danger alert-dismissible" role="alert">' . $firstname .' '. $lastname. ' ' .'Loan Updates Failed.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
            }            
        }
    }

    /*
    ** Display all Matured Loans.
    */   
    public function matured() {

        //get the title.
        $title = 'Matured Loans.';

        //get the loans whose status is one.
        $loans = Loan::where('state', '=', 2)->orderBy('created_at','desc')->get();                                               

        return View('auth.members.loan.maturedLoans', compact('loans'))
                ->with('title', $title); 
    }

    /*
    ** Display all mous based Matured Loans.
    */   
    public function mouMatured() {

        //get the title.
        $title = 'Corporate Matured Loans.';

        //get the loans whose status is one.
        $loans = Loan::where('state', '=', 2)->get();  

        //get the summations of the monthly installment.
        $sumonthly = Loan::where('loanEntity', '=', 'institution x')->sum('monthlyInstallment');                                             

        return View('auth.members.loan.mouMaturedLoans', compact('loans', 'sumonthly'))
                ->with('title', $title); 
    }

    /*
    ** Display all mous based Matured Loans.
    */ 
     public function storeCorporateLoans() {

        //find the loans under the said umbrella.
        //sum up their monthly installments.
        $corporate = Loan::where('loanEntity', '=', 'institution x')->sum('monthlyInstallment');

        //moneys paid by the entity
        $paid = 143000;

        //ensure that all loan installments are paid in full.
        $tight = $paid - $corporate;

        if ($tight == 0) {

            $corps = Loan::where('loanEntity', '=', 'institution x')->get();
            
            foreach($corps as $corp) {

                //get the id.
                $id = $corp->id;

                //get the installment.
                $installment = $corp->monthlyInstallment;

                //find individual loans.
                $loan   = Loan::find($id);

                //find how many months are left in completion of the loan repayment.
                $left = $loan->loanDuration;

                $monthsLeft = $left - 1;

                //this means this is the last day to pay the installments.
                $datta = [

                    'installment' => $installment,
                    'daysLeft'    => $monthsLeft
                ];                    

                $dexter = $loan->installments()->create($datta);  

                //we need to update the totalInstallments field in the loans table.

                

                //get the total installments.
                $total = $loan->totalInstallments;

                //do a summation to the existing total installments.
                $summation = $total + $installment;

                //update the loan date.
                $dateUpdate = $loan->loanDate + 1;

                //update the grace period.
                $gracei     = $loan->gracePeriod + 1;

                //update the loan state.
                $stateUpdate = $loan->state = 2 ;

                //get the data.
                $data = [

                    'totalInstallments' => $summation,
                    'loanDate'          => $dateUpdate,
                    'gracePeriod'       => $gracei,
                    'state'             => $stateUpdate
                ];

                //update the loans table.
                $loan->update($data);
            }

            return redirect()->route('mouMaturedLoans')
                ->with('global', '<p style="20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-info alert-dismissible" role="alert">' . 'Installments Successfully Recorded.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
        }
        else {

            return redirect()->route('mouMaturedLoans')
                ->with('global', '<p style="20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-danger alert-dismissible" role="alert">' . 'Installments NOT Recorded.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
        }

        
        
     }

    /*
    ** Display Default Loans.
    */  
    public function defaults() {

        //get the title.
        $title = 'Default Loans.';

        //get the loans whose status is three.
        $loans = Loan::where('state', '=', 3)->get();  
        
        return View('auth.members.loan.defaultLoans', compact('loans'))
            ->with('title', $title);        
    }

    /**
    ** Pay Installments Today.
    **/
    public function pay() {

        $title = 'Today Payments.';

        //get all the matured loans.
        $loaners = Member::where('loanStatus', '=', 1)->get();

        //get the records of installments entered into the database.
        $loans    = Loan::where('state', '=', 1)->pluck('id');

        //get the loans via id.
        $loanId   = Loan::find($loans);
        
        //from the above, we can equally get the count on how many installments are there.
        $count    = $loanId->installments()->count();   

        //get when the loan was created.
        $creatte  = Loan::where('state', '=', 1)->pluck('created_at');

        //get the loan duration.
        $duration = Loan::where('state', '=', 1)->pluck('loanDuration');

        //get how many days have passed since the loan was processed.
        $daysPass = $creatte->addDays($duration)->diffInDays();

        return View('auth.members.loan.payToday', compact('loaners', 'count', 'daysPass'))
            ->with('title', $title);
    }

    /*
    ** commit installments.
    */
    public function storeInstallments(Request $request) {

        //validation.
        $this->validate($request, [
            'installment' => 'required',
            'id'          => 'required'
            ]);

        if ($request->fails) {
            
            //return an error.
            return response()->json([ 'error' => 'You Have Empty Field(s)' ], 200);
        }
        else {

            //get the installment.
            $installment = $request->installment;

            //get the id of the loan.
            $id          = $request->id;

            //check if the loan in question has any active installments.
            $checkInstallment = Installment::where('loan_id', '=', $id)->count();

            //get the last day of reimbursements to the sacco.
            $lastDay = Carbon::now()->endOfMonth()->subDays(13)->endOfDay();

            //get today.
            $today   = Carbon::now();

            //if the checkInstallment is 0, it means this is the first installment.
            if ($checkInstallment == 0) {
                
                //ensure that the member repaying the installments hasn't defaulted.

                //check validity.
                if ($today == $lastDay) {

                    //find individual loans.
                    $loan   = Loan::find($id);

                    //find how many months are left in completion of the loan repayment.
                    $left = $loan->loanDuration;

                    $monthsLeft = $left - 1;

                    //this means this is the last day to pay the installments.
                    $datta = [

                        'installment' => $installment,
                        'daysLeft'    => $monthsLeft,
                    ];                    

                    $dexter = $loan->installments()->create($datta);  

                    //we need to update the totalInstallments field in the loans table.

                    //access the loan with appropriate paramenters
                    $loan = Loan::where('member_id', '=', $id)->first();

                    //get the total installments.
                    $total = $loan->totalInstallments;

                    //do a summation to the existing total installments.
                    $summation = $total + $installment;

                    //update the loan date.
                    $dateUpdate = $loan->loanDate + 1;

                    //update the grace period.
                    $gracei     = $loan->gracePeriod + 1;

                    //update the loan state.
                    $stateUpdate = $loan->state = 2 ;

                    //get the data.
                    $data = [

                        'totalInstallments' => $summation,
                        'loanDate'          => $dateUpdate,
                        'gracePeriod'       => $gracei,
                        'state'             => $stateUpdate
                    ];

                    //update the loans table.
                    DB::table('loans')->where('member_id', '=', $id)->update($data);

                    return response()->json([ 'response' => 'Installment Successfully processed..' ], 200);
                }
                else if ($today <= $lastDay) {

                    //find individual loans.
                    $loan   = Loan::find($id);

                    //find how many months are left in completion of the loan repayment.
                    $left = $loan->loanDuration;

                    $monthsLeft = $left - 1;

                    //this means this is the last day to pay the installments.
                    $datta = [

                        'installment' => $installment,
                        'daysLeft'    => $monthsLeft,
                    ];                    

                    $dexter = $loan->installments()->create($datta);  

                    //we need to update the totalInstallments field in the loans table.

                    //access the loan with appropriate paramenters
                    $loan = Loan::where('member_id', '=', $id)->first();

                    //get the total installments.
                    $total = $loan->totalInstallments;

                    //do a summation to the existing total installments.
                    $summation = $total + $installment;

                    //update the loan date.
                    $dateUpdate = $loan->loanDate + 1;

                    //update the grace period.
                    $gracei     = $loan->gracePeriod + 1;

                    //update the loan state.
                    $stateUpdate = $loan->state = 2 ;

                    //get the data.
                    $data = [

                        'totalInstallments' => $summation,
                        'loanDate'          => $dateUpdate,
                        'gracePeriod'       => $gracei,
                        'state'             => $stateUpdate
                    ];

                    //update the loans table.
                    DB::table('loans')->where('member_id', '=', $id)->update($data);

                    return response()->json([ 'response' => 'Installment Successfully processed.' ], 200);
                }
                else {

                    return response()->json([ 'response' => 'NOT Applicable.' ], 200);
                }               
            }
            else if($checkInstallment > 0) {

                //this means that this is not the first installments to be processed from this loan.
                
                //check validity.
                if ($today == $lastDay) {

                    //find individual loans.
                    $loan   = Loan::find($id);

                    //find how many months are left in completion of the loan repayment.
                    $left = Installment::where('loan_id', '=', $id)->latest()->pluck('daysLeft');

                    $monthsLeft = $left - 1;

                    //this means this is the last day to pay the installments.
                    $datta = [

                        'installment' => $installment,
                        'daysLeft'    => $monthsLeft,
                    ]; 

                    $dexter = $loan->installments()->create($datta);  

                    //we need to update the totalInstallments field in the loans table.

                    //access the loan with appropriate paramenters
                    $loan = Loan::where('member_id', '=', $id)->first();

                    //get the total installments.
                    $total = $loan->totalInstallments;

                    //do a summation to the existing total installments.
                    $summation = $total + $installment;

                    //update the loan date.
                    $dateUpdate = $loan->loanDate + 1;

                    //update the grace period.
                    $gracei     = $loan->gracePeriod + 1;

                    //update the loan state.
                    $stateUpdate = $loan->state = 2 ;

                    //get the data.
                    $data = [

                        'totalInstallments' => $summation,
                        'loanDate'          => $dateUpdate,
                        'gracePeriod'       => $gracei,
                        'state'             => $stateUpdate
                    ];

                    //update the loans table.
                    DB::table('loans')->where('member_id', '=', $id)->update($data);

                    return response()->json([ 'response' => 'Installment Successfully processed' ], 200);
                }
                else if($today <= $lastDay) {

                    //find individual loans.
                    $loan   = Loan::find($id);

                    //increment the value of the loan date.
                    $loanInc = $loan->loanDate + 1;

                    //we need to update the loanDate field in our loans table.
                    $dent = [

                        'loanDate' => $loanInc
                    ];

                    $loan->update($dent);

                    //find how many months are left in completion of the loan repayment.
                    $left = Installment::where('loan_id', '=', $id)->latest()->pluck('daysLeft');

                    $monthsLeft = $left - 1;

                    //this means this is the last day to pay the installments.
                    $datta = [

                        'installment' => $installment,
                        'daysLeft'    => $monthsLeft,
                    ]; 

                    $dexter = $loan->installments()->create($datta);

                    //we need to update the totalInstallments field in the loans table.

                    //access the loan with appropriate paramenters
                    $loan = Loan::where('member_id', '=', $id)->first();

                    //get the total installments.
                    $total = $loan->totalInstallments;

                    //do a summation to the existing total installments.
                    $summation = $total + $installment;

                    //update the loan date.
                    $dateUpdate = $loan->loanDate + 1;

                    //update the grace period.
                    $gracei     = $loan->gracePeriod + 1;

                    //update the loan state.
                    $stateUpdate = $loan->state = 2 ;

                    //get the data.
                    $data = [

                        'totalInstallments' => $summation,
                        'loanDate'          => $dateUpdate,
                        'gracePeriod'       => $gracei,
                        'state'             => $stateUpdate
                    ];

                    //update the loans table.
                    DB::table('loans')->where('member_id', '=', $id)->update($data);  

                    return response()->json([ 'response' => 'Installment Successfully processed' ], 200);
                }
            }
            else {

                return response()->json([ 'response' => 'NOT Applicable.' ], 200);
            } 
        }
    }

    /*
    ** commit Default installments.
    */
    public function storeDefaultInstallments(Request $request) {

        //validation.
        $this->validate($request, [
            'installment' => 'required',
            'id'          => 'required',
            'bank'        => 'required'
            ]);

        if ($request->fails) {
            
            //return an error.
            return response()->json([ 'error' => 'You Have Empty Field(s)' ], 200);
        }
        else {

            $id = $request->id;

            $installment = $request->installment;

            $bank = $request->bank;

            //get the last day of reimbursements to the sacco.
            $lastDay = Carbon::now()->endOfMonth()->subDays(13);

            //get today.
            $today   = Carbon::now();

            //check if the loan in question has any active installments.
            $checkInstallment = Installment::where('loan_id', '=', $id)->count();

            if($checkInstallment == 0) {

                //get the loan via id
                $loan   = Loan::find($id);

                //grab the monthly installment as agreed by the sacco.
                $monthlyInstallment = $loan->member->monthlyInstallment;

                if($installment == $monthlyInstallment) {

                    //this means that this member has defaulted in paying the installments.
                    //equally count the number of defaults the member has incurred.

                    //find how many months are left in completion of the loan repayment.
                    $left = $loan->loanDuration;

                    $monthsLeft = $left - 1;

                    $messOne = 'No additional Default Interest.';

                    //this means this is the last day to pay the installments.
                    $datta = [

                        'installment' => $installment,
                        'monthsLeft'  => $monthsLeft,
                        'bank'        => $bank,
                    ];

                    //use the relationship to create loan installments.
                    $dexter = $loan->installments()->create($datta);

                    //update the defaults value in the db.
                    $loan->installments()->update(['defaults' => 1]);

                    //get the loan amount
                    $amount = $loan->where('id', '=', $id)->pluck('amount');

                    //get the loan applied for.
                    $loanApp = $loan->where('id', '=', $id)->pluck('loan');

                    //get the loan duration.
                    $duration = $loan->where('id', '=', $id)->pluck('loanDuration');

                    //get the interest 44,000 - 40,000 == 4,000
                    $interest = $amount - $loanApp;

                    //divide this loan by the loan duration. 40000 / 4  == 10,000
                    $loanDivide = $loan->loan / $duration;

                    //divide the interest by the loan duration. 4,000 / 4  == 1,000
                    $interestDivide = $interest / $duration;

                    //verify the installment.
                    $verify = $loanDivide + $interestDivide;

                    //In here we need to update the chart of accounts.
                    //we need to update the interest income
                    //we also need to update the reimbursement account payable.

                    //we need to get the Interest Income and update its detail from our charts table.
                    Chart::where('accountName', '=', 'Interest Income')->increment('detail', $interestDivide);

                    //we equally need to increment the reimbursements account on our charts table.
                    Chart::where('accountName', '=', 'Reimbursements')->increment('detail', $loanDivide);

                    //we equally need to increment the bank i.e. coop bank
                    Chart::where('accountName', '=', 'Co-op Bank')->increment('money', $installment);

                    //get the ratio to cut down guarantors money.
                    $ratio = 300/100;

                    //distribute the remainder to the guarantors money.
                    $remainder = $installment / $ratio;

                    $cutone   = $loan->guaranteeOne;
                    $cuttwo   = $loan->guaranteeTwo;
                    $cutthree = $loan->guaranteeThree;

                    Loan::where('id', '=', $id)->decrement('moneyOne', round($remainder, 1));
                    Loan::where('id', '=', $id)->decrement('moneyTwo', round($remainder, 1));
                    Loan::where('id', '=', $id)->decrement('moneyThree', round($remainder, 1));                         


                    //we need to update the totalInstallments field in the loans table.
                    $loan = Loan::where('id', '=', $id)->first();

                    //get the total installments.
                    $total = $loan->totalInstallments;

                    //get to total summation
                    $summation = $total + $installment;

                    //update the loan date.
                    $dateUpdate = $loan->loanDate + 1;

                    //take the date in which the installment was paid.
                    $payDay = Carbon::now();

                    //get the months left in repaying the loan
                    //NOTE: months left only counts how many months the loan has been paid.
                    //$leftMonths = $loan->installments()->latest->pluck('monthsLeft');
                       
                    //this means that i haven't finished paying the loan installments.
                    //therefore we need to get today and subtract it from end of the current month.
                    $gracei = $payDay->endOfMonth()->diffInDays();

                    //update the loan state.
                    $stateUpdate = $loan->state = 2 ;

                    //update the db.
                    $data = [

                        'totalInstallments' => $summation,
                        'loanDate'          => $dateUpdate,
                        'state'             => $stateUpdate,
                        'gracePeriod'       => $gracei
                    ];

                    $loan->update($data);

                    //update the totals of the member who has applied for the loan
                    $loan->where('member_id', '=', $id)->member->increment('totals', $installment);

                    //guarantor one
                    $loan->where('member_id', '=', $id)->where('guaranteeOne', '=', $cutone)->member->increment('totals', round($remainder, 1));

                    //guarantor two
                    $loan->where('member_id', '=', $id)->where('guaranteeTwo', '=', $cuttwo)->member->increment('totals', round($remainder, 1));

                    //guarantor one
                    $loan->where('member_id', '=', $id)->where('guaranteeThree', '=', $cutthree)->member->increment('totals', round($remainder, 1));

                    return response()->json([ 'response' => 'Installment Successfully processed.' ], 200);                   
                }
                else if($installment < $monthlyInstallment) {

                    //this means that this member has defaulted in paying the installments.
                    //equally count the number of defaults the member has incurred.

                    //find how many months are left in completion of the loan repayment.
                    $left = $loan->loanDuration;

                    $monthsLeft = $left - 1;

                    $messOne = 'No additional Default Interest.';

                    //this means this is the last day to pay the installments.
                    $datta = [

                        'installment' => $installment,
                        'monthsLeft'  => $monthsLeft,
                        'bank'        => $bank,
                    ];

                    //use the relationship to create loan installments.
                    $dexter = $loan->installments()->create($datta);

                    //update the defaults value in the db.
                    $loan->installments()->update(['defaults' => 1]);


                    //In here we need to update the chart of accounts.
                    //we need to update the interest income
                    //we also need to update the reimbursement account payable.

                    $ninety = 90/100;

                    $ten    = 10/100;

                    $ninetyDisburse = $installment * $ninety;
                    $tenInterest    = $installment * $ten;

                    //we need to get the Interest Income and update its detail from our charts table.
                    Chart::where('accountName', '=', 'Interest Income')->increment('detail', $tenInterest);

                    //we equally need to increment the reimbursements account on our charts table.
                    Chart::where('accountName', '=', 'Reimbursements')->increment('detail', $ninetyDisburse);

                    //we equally need to increment the bank i.e. coop bank
                    Chart::where('accountName', '=', 'Co-op Bank')->increment('money', $installment);

                    //get the ratio to cut down guarantors money.
                    $ratio = 300/100;

                    //distribute the remainder to the guarantors money.
                    $remainder = $installment / $ratio;

                    $cutone   = $loan->guaranteeOne;
                    $cuttwo   = $loan->guaranteeTwo;
                    $cutthree = $loan->guaranteeThree;

                    Loan::where('id', '=', $id)->decrement('moneyOne', round($remainder, 1));
                    Loan::where('id', '=', $id)->decrement('moneyTwo', round($remainder, 1));
                    Loan::where('id', '=', $id)->decrement('moneyThree', round($remainder, 1));           

                    //we need to update the totalInstallments field in the loans table.
                    $loan = Loan::where('id', '=', $id)->first();

                    //get the total installments.
                    $total = $loan->totalInstallments;

                    //get to total summation
                    $summation = $total + $installment;

                    //update the loan date.
                    $dateUpdate = $loan->loanDate + 1;

                    //take the date in which the installment was paid.
                    $payDay = Carbon::now();

                    //get the months left in repaying the loan
                    //NOTE: months left only counts how many months the loan has been paid.
                    //$leftMonths = $loan->installments()->latest->pluck('monthsLeft');

                    //this means that i haven't finished paying the loan installments.
                    //therefore we need to get today and subtract it from end of the current month.
                    $gracei = $payDay->endOfMonth()->diffInDays();

                    //update the loan state.
                    $stateUpdate = $loan->state = 3;

                    //update the db.
                    $data = [

                        'totalInstallments' => $summation,
                        'loanDate'          => $dateUpdate,
                        'state'             => $stateUpdate,
                        'gracePeriod'       => $gracei
                    ];

                    $loan->update($data);

                    $loan->where('member_id', '=', $id)->member->increment('totals', $installment);

                    //guarantor one
                    $loan->where('member_id', '=', $id)->where('guaranteeOne', '=', $cutone)->member->increment('totals', round($remainder, 1));

                    //guarantor two
                    $loan->where('member_id', '=', $id)->where('guaranteeTwo', '=', $cuttwo)->member->increment('totals', round($remainder, 1));

                    //guarantor one
                    $loan->where('member_id', '=', $id)->where('guaranteeThree', '=', $cutthree)->member->increment('totals', round($remainder, 1));

                    return response()->json([ 'response' => 'Installment Successfully processed.' ], 200);                   
                }
                else if($installment > $monthlyInstallment) {

                    //this means that this member has defaulted in paying the installments.
                    //equally count the number of defaults the member has incurred.

                    //find how many months are left in completion of the loan repayment.
                    $left = $loan->loanDuration;

                    $monthsLeft = $left - 1;

                    $messOne = 'No additional Default Interest.';

                    //this means this is the last day to pay the installments.
                    $datta = [

                        'installment' => $installment,
                        'monthsLeft'  => $monthsLeft,
                        'bank'        => $bank,
                        'defaults'    => 1
                    ];

                    //use the relationship to create loan installments.
                    $dexter = $loan->installments()->create($datta);

                    //update the defaults value in the db.
                    $loan->installments()->update(['defaults' => 1]);


                    //In here we need to update the chart of accounts.
                    //we need to update the interest income
                    //we also need to update the reimbursement account payable.

                    $ninety = 90/100;

                    $ten    = 10/100;

                    $ninetyDisburse = $installment * $ninety;
                    $tenInterest    = $installment * $ten;

                    //we need to get the Interest Income and update its detail from our charts table.
                    Chart::where('accountName', '=', 'Interest Income')->increment('detail', $tenInterest);

                    //we equally need to increment the reimbursements account on our charts table.
                    Chart::where('accountName', '=', 'Reimbursements')->increment('detail', $ninetyDisburse);

                    //we equally need to increment the bank i.e. coop bank
                    Chart::where('accountName', '=', 'Co-op Bank')->increment('money', $installment);

                    //get the ratio to cut down guarantors money.
                    $ratio = 300/100;

                    //distribute the remainder to the guarantors money.
                    $remainder = $installment / $ratio;

                    $cutone   = $loan->guaranteeOne;
                    $cuttwo   = $loan->guaranteeTwo;
                    $cutthree = $loan->guaranteeThree;

                    Loan::where('id', '=', $id)->decrement('moneyOne', round($remainder, 1));
                    Loan::where('id', '=', $id)->decrement('moneyTwo', round($remainder, 1));
                    Loan::where('id', '=', $id)->decrement('moneyThree', round($remainder, 1));
                       
                    //we need to update the totalInstallments field in the loans table.
                    $loan = Loan::where('id', '=', $id)->first();

                    //get the total installments.
                    $total = $loan->totalInstallments;

                    //get to total summation
                    $summation = $total + $installment;

                    //update the loan date.
                    $dateUpdate = $loan->loanDate + 1;

                    //take the date in which the installment was paid.
                    $payDay = Carbon::now();

                    //get the months left in repaying the loan
                    //NOTE: months left only counts how many months the loan has been paid.
                    //$leftMonths = $loan->installments()->latest->pluck('monthsLeft');

                    //this means that i haven't finished paying the loan installments.
                    //therefore we need to get today and subtract it from end of the current month.
                    $gracei = $payDay->endOfMonth()->diffInDays();

                    //update the loan state.
                    $stateUpdate = $loan->state = 2 ;

                    //update the db.
                    $data = [

                        'totalInstallments' => $summation,
                        'loanDate'          => $dateUpdate,
                        'state'             => $stateUpdate,
                        'gracePeriod'       => $gracei
                    ];

                    $loan->update($data);

                    $loan->member->increment('totals', $installment);

                    //guarantor one
                    $loan->member->where('accountNumber', '=', $cutone)->increment('totals', round($remainder, 1));

                    //guarantor one money
                    $loan->member->where('accountNumber', '=', $cutone)->decrement('guarantorMoney', round($remainder, 1));

                    //guarantor two
                    $loan->member->where('accountNumber', '=', $cuttwo)->increment('totals', round($remainder, 1));

                    //guarantor two money
                    $loan->member->where('accountNumber', '=', $cuttwo)->decrement('guarantorMoney', round($remainder, 1));

                    //guarantor three
                    $loan->member->where('accountNumber', '=', $cutthree)->increment('totals', round($remainder, 1));

                    //guarantor three money
                    $loan->member->where('accountNumber', '=', $cutthree)->increment('guarantorMoney', round($remainder, 1));

                    return response()->json([ 'response' => 'Installment Successfully processed.' ], 200);                 
                }
                else {

                    return response()->json([ 'response' => 'NOT Applicable.' ], 200);
                } 
            }
            else if ($checkInstallment > 0) {

                //get the loan via id
                $loan   = Loan::find($id);

                //grab the monthly installment as agreed by the sacco.
                $monthlyInstallment = $loan->member->monthlyInstallment;
                
                if($monthlyInstallment == $installment) {

                    //this means that this member has defaulted in paying the installments.
                    //equally count the number of defaults the member has incurred.

                    //find how many months are left in completion of the loan repayment.
                    $left = $loan->loanDuration;

                    $monthsLeft = $left - 1;

                    $messOne = 'No additional Default Interest.';

                    //this means this is the last day to pay the installments.
                    $datta = [

                        'installment' => $installment,
                        'monthsLeft'  => $monthsLeft,
                        'bank'        => $bank,
                        'defaults'    => 1
                    ];

                    //use the relationship to create loan installments.
                    $dexter = $loan->installments()->create($datta);

                    //update the defaults value in the db.
                    $loan->installments()->update(['defaults' => 1]);

                    //get the loan amount
                    $amount = $loan->where('id', '=', $id)->pluck('amount');

                    //get the loan applied for.
                    $loanApp = $loan->where('id', '=', $id)->pluck('loan');

                    //get the loan duration.
                    $duration = $loan->where('id', '=', $id)->pluck('loanDuration');

                    //get the interest 44,000 - 40,000 == 4,000
                    $interest = $amount - $loanApp;

                    //divide this loan by the loan duration. 40000 / 4  == 10,000
                    $loanDivide = $loan->loan / $duration;

                    //divide the interest by the loan duration. 4,000 / 4  == 1,000
                    $interestDivide = $interest / $duration;

                    //verify the installment.
                    $verify = $loanDivide + $interestDivide;

                    //In here we need to update the chart of accounts.
                    //we need to update the interest income
                    //we also need to update the reimbursement account payable.

                    //we need to get the Interest Income and update its detail from our charts table.
                    Chart::where('accountName', '=', 'Interest Income')->increment('detail', $interestDivide);

                    //we equally need to increment the reimbursements account on our charts table.
                    Chart::where('accountName', '=', 'Reimbursements')->increment('detail', $loanDivide);

                    //we equally need to increment the bank i.e. coop bank
                    Chart::where('accountName', '=', 'Co-op Bank')->increment('money', $installment);

                    //get the ratio to cut down guarantors money.
                    $ratio = 300/100;

                    //distribute the remainder to the guarantors money.
                    $remainder = $installment / $ratio;

                    $cutone   = $loan->guaranteeOne;
                    $cuttwo   = $loan->guaranteeTwo;
                    $cutthree = $loan->guaranteeThree;

                    Loan::where('id', '=', $id)->decrement('moneyOne', $remainder);
                    Loan::where('id', '=', $id)->decrement('moneyTwo', $remainder);
                    Loan::where('id', '=', $id)->decrement('moneyThree', $remainder);                  

                    //we need to update the totalInstallments field in the loans table.
                    $loan = Loan::where('id', '=', $id)->first();

                    //get the total installments.
                    $total = $loan->totalInstallments;

                    //get to total summation
                    $summation = $total + $installment;

                    //update the loan date.
                    $dateUpdate = $loan->loanDate + 1;

                    //take the date in which the installment was paid.
                    $payDay = Carbon::now();

                    //get the months left in repaying the loan
                    //NOTE: months left only counts how many months the loan has been paid.
                    $leftMonths = $loan->installments()->latest->pluck('monthsLeft');

                    if ($left >= $leftMonths) {
                       
                        //this means that i haven't finished paying the loan installments.
                        //therefore we need to get today and subtract it from end of the current month.
                        $gracei = $payDay->endOfMonth()->diffInDays();

                        //update the loan state.
                        $stateUpdate = $loan->state = 2 ;

                        //update the db.
                        $data = [

                            'totalInstallments' => $summation,
                            'loanDate'          => $dateUpdate,
                            'state'             => $stateUpdate,
                            'gracePeriod'       => $gracei
                        ];

                        $loan->update($data);

                        Loan::where('member_id', '=', $id)->member->increment('totals', $installment);

                        //guarantor one
                        Loan::where('guarantorOne', '=', $cutone)->member->increment('totals', $remainder);

                        //guarantor two
                        Loan::where('guarantorTwo', '=', $cuttwo)->member->increment('totals', $remainder);

                        //guarantor one
                        Loan::where('guarantorThree', '=', $cutthree)->member->increment('totals', $remainder);

                        return response()->json([ 'response' => 'Installment Successfully processed.' ], 200);
                    }
                    else {

                        return response()->json([ 'response' => 'Loan Reimbursements Complete.' ], 200);
                    }                    
                }
                else if($installment < $monthlyInstallment) {

                    //this means that this member has defaulted in paying the installments.
                    //equally count the number of defaults the member has incurred.

                    //find how many months are left in completion of the loan repayment.
                    $left = $loan->loanDuration;

                    $monthsLeft = $left - 1;

                    $messOne = 'No additional Default Interest.';

                    //this means this is the last day to pay the installments.
                    $datta = [

                        'installment' => $installment,
                        'monthsLeft'  => $monthsLeft,
                        'bank'        => $bank,
                        'defaults'    => 1
                    ];

                    //use the relationship to create loan installments.
                    $dexter = $loan->installments()->create($datta);

                    //update the defaults value in the db.
                    $loan->installments()->update(['defaults' => 1]);


                    //In here we need to update the chart of accounts.
                    //we need to update the interest income
                    //we also need to update the reimbursement account payable.

                    $ninety = 90/100;

                    $ten    = 10/100;

                    $ninetyDisburse = $installment * $ninety;
                    $tenInterest    = $installment * $ten;

                    //we need to get the Interest Income and update its detail from our charts table.
                    Chart::where('accountName', '=', 'Interest Income')->increment('detail', $tenInterest);

                    //we equally need to increment the reimbursements account on our charts table.
                    Chart::where('accountName', '=', 'Reimbursements')->increment('detail', $ninetyDisburse);

                    //we equally need to increment the bank i.e. coop bank
                    Chart::where('accountName', '=', 'Co-op Bank')->increment('money', $installment);

                    //get the ratio to cut down guarantors money.
                    $ratio = 300/100;

                    //distribute the remainder to the guarantors money.
                    $remainder = $installment / $ratio;

                    $cutone   = $loan->guaranteeOne;
                    $cuttwo   = $loan->guaranteeTwo;
                    $cutthree = $loan->guaranteeThree;

                    Loan::where('id', '=', $id)->decrement('moneyOne', $remainder);
                    Loan::where('id', '=', $id)->decrement('moneyTwo', $remainder);
                    Loan::where('id', '=', $id)->decrement('moneyThree', $remainder);                    

                    //we need to update the totalInstallments field in the loans table.
                    $loan = Loan::where('id', '=', $id)->first();

                    //get the total installments.
                    $total = $loan->totalInstallments;

                    //get to total summation
                    $summation = $total + $installment;

                    //update the loan date.
                    $dateUpdate = $loan->loanDate + 1;

                    //take the date in which the installment was paid.
                    $payDay = Carbon::now();

                    //get the months left in repaying the loan
                    //NOTE: months left only counts how many months the loan has been paid.
                    $leftMonths = $loan->installments()->latest->pluck('monthsLeft');

                    if ($left >= $leftMonths) {
                       
                        //this means that i haven't finished paying the loan installments.
                        //therefore we need to get today and subtract it from end of the current month.
                        $gracei = $payDay->endOfMonth()->diffInDays();

                        //update the loan state.
                        $stateUpdate = $loan->state = 3;

                        //update the db.
                        $data = [

                            'totalInstallments' => $summation,
                            'loanDate'          => $dateUpdate,
                            'state'             => $stateUpdate,
                            'gracePeriod'       => $gracei
                        ];

                        $loan->update($data);

                        Loan::where('member_id', '=', $id)->member->increment('totals', $installment);

                        //guarantor one
                        Loan::where('guarantorOne', '=', $cutone)->member->increment('totals', $remainder);

                        //guarantor two
                        Loan::where('guarantorTwo', '=', $cuttwo)->member->increment('totals', $remainder);

                        //guarantor one
                        Loan::where('guarantorThree', '=', $cutthree)->member->increment('totals', $remainder);

                        return response()->json([ 'response' => 'Installment Successfully processed.' ], 200);
                    }
                    else {

                        return response()->json([ 'response' => 'Loan Reimbursements Complete.' ], 200);
                    }                    
                }
                else if($installment > $monthlyInstallment) {

                    //this means that this member has defaulted in paying the installments.
                    //equally count the number of defaults the member has incurred.

                    //find how many months are left in completion of the loan repayment.
                    $left = $loan->loanDuration;

                    $monthsLeft = $left - 1;

                    $messOne = 'No additional Default Interest.';

                    //this means this is the last day to pay the installments.
                    $datta = [

                        'installment' => $installment,
                        'monthsLeft'  => $monthsLeft,
                        'bank'        => $bank,
                        'defaults'    => 1
                    ];

                    //use the relationship to create loan installments.
                    $dexter = $loan->installments()->create($datta);

                    //update the defaults value in the db.
                    $loan->installments()->update(['defaults' => 1]);


                    //In here we need to update the chart of accounts.
                    //we need to update the interest income
                    //we also need to update the reimbursement account payable.

                    $ninety = 90/100;

                    $ten    = 10/100;

                    $ninetyDisburse = $installment * $ninety;
                    $tenInterest    = $installment * $ten;

                    //we need to get the Interest Income and update its detail from our charts table.
                    Chart::where('accountName', '=', 'Interest Income')->increment('detail', $tenInterest);

                    //we equally need to increment the reimbursements account on our charts table.
                    Chart::where('accountName', '=', 'Reimbursements')->increment('detail', $ninetyDisburse);

                    //we equally need to increment the bank i.e. coop bank
                    Chart::where('accountName', '=', 'Co-op Bank')->increment('money', $installment);

                    //get the ratio to cut down guarantors money.
                    $ratio = 300/100;

                    //distribute the remainder to the guarantors money.
                    $remainder = $installment / $ratio;

                    $cutone   = $loan->guaranteeOne;
                    $cuttwo   = $loan->guaranteeTwo;
                    $cutthree = $loan->guaranteeThree;

                    Loan::where('id', '=', $id)->decrement('moneyOne', $remainder);
                    Loan::where('id', '=', $id)->decrement('moneyTwo', $remainder);
                    Loan::where('id', '=', $id)->decrement('moneyThree', $remainder);                       

                    //we need to update the totalInstallments field in the loans table.
                    $loan = Loan::where('id', '=', $id)->first();

                    //get the total installments.
                    $total = $loan->totalInstallments;

                    //get to total summation
                    $summation = $total + $installment;

                    //update the loan date.
                    $dateUpdate = $loan->loanDate + 1;

                    //take the date in which the installment was paid.
                    $payDay = Carbon::now();

                    //get the months left in repaying the loan
                    //NOTE: months left only counts how many months the loan has been paid.
                    $leftMonths = $loan->installments()->latest->pluck('monthsLeft');

                    if ($left >= $leftMonths) {
                       
                        //this means that i haven't finished paying the loan installments.
                        //therefore we need to get today and subtract it from end of the current month.
                        $gracei = $payDay->endOfMonth()->diffInDays();

                        //update the loan state.
                        $stateUpdate = $loan->state = 2 ;

                        //update the db.
                        $data = [

                            'totalInstallments' => $summation,
                            'loanDate'          => $dateUpdate,
                            'state'             => $stateUpdate,
                            'gracePeriod'       => $gracei
                        ];

                        $loan->update($data);

                        Loan::where('member_id', '=', $id)->member->increment('totals', $installment);

                        //guarantor one
                        Loan::where('guarantorOne', '=', $cutone)->member->increment('totals', $remainder);

                        //guarantor two
                        Loan::where('guarantorTwo', '=', $cuttwo)->member->increment('totals', $remainder);

                        //guarantor one
                        Loan::where('guarantorThree', '=', $cutthree)->member->increment('totals', $remainder);

                        return response()->json([ 'response' => 'Installment Successfully processed.' ], 200);
                    }
                    else {

                        return response()->json([ 'response' => 'Loan Reimbursements Complete.' ], 200);
                    }                    
                }
                else {

                    return response()->json([ 'response' => 'NOT Applicable.' ], 200);
                } 
            }            
            return response()->json([ 'response' => 'False' ], 200);
        }
    }

    /**
    ** Installment Updates.
    **/
    public function installmentUpdates(Request $request, $id) {

        $title = 'Installment Updates.';

        //find the member via id and pass it along to the view.
        $loan   = Loan::find($id);

        //at what point in time was the last update done.
        $record = $loan->installments()->latest()->first();
        
        $last   = $record->updated_at->formatLocalized('%a %d %b %y');

        //get the total installment as well.
        $cash   = $loan->pluck('totalInstallments');

        //get the status of the loan belonging to each member.
        $status = $loan->pluck('state');

        //get the installments of each loan.
        $installs = $loan->installments()->get();

        return View('auth.members.loan.installmentUpdates', compact('loan', 'last', 'cash', 'status', 'installs'))
            ->with('title', $title);
    }

    /**
    ** Installment Updates Commit.
    **/
    public function installmentUpdatesStore(Request $request, $id) {

        //validation.
        $this->validate($request, [
            'installment' => 'required',
            'id'          => 'required'
            ]);

        if ($request->fails) {
            
            return response()->json([ 'error' => 'You\'ve Got Empty Fields.' ], 200);
        }
        else {

            //get the data from ajax.
            $installment = $request->installment;

            $id          = $request->id;

            //get the data to update.
            $data = [

                'installment' => $installment,
            ];

            $updates = Installment::where('id', '=', $id)->update($data);

            //we need to update the loans table.
            $install = Installment::find($id);

            $data = [

                'totalInstallments' => $installment
            ];

            $linna   = $install->loan()->update($data);

            if ($updates) {
                
                return response()->json([ 'response' => 'Installment Updates Successfully Done.' ], 200);
            }
            else {

                return response()->json([ 'error' => 'Installment Updates NOT Successful.' ], 200);
            }
            
        }
    }

    /*
    ** Loans data in Json.
    */
    public function loansJson() {

        //display only matured loans.
        $loans = Loan::where('state', '=', 2)->get();

        return response()->json([ 'laravel' => $loans ], 200);
    }

    /**
    ** Loan analysis for defaulters.
    **/
    public function analyseLoanDefaulters($id) {

        //get the loan.
        $loan = Loan::find($id);

        //get today.
        $today = Carbon::now();

        $contra = $loan->disbursements->count();

        if ($contra > 0) {

            if ($today < $loan->created_at->addDays($loan->gracePeriod) ) {
            
                dd('Grace Period.');
            }
            else if ($today > $loan->created_at->addDays($loan->gracePeriod) ) {
                
                //then we need to check first if there is any installments made from this loan.
                $installs = $loan->installments->count();

                if ($installs) {
                    
                    dd('YES installments.');

                    //first get the agreed monthly installment.
                    $monthlyInstallment = $loan->monthlyInstallment;

                    //grab the latest monthly installment done by the member of this loan
                    $paidInstallments = $loan->installments()->latest()->pluck('installment');

                    
                }
                else {

                    //if no installment and the grace period is over, this means that the member who 
                    //applied for this loan has defaulted.
                    //change the state of the loan to 3.
                    $dataDefault = [

                        'state' => 3
                    ];

                    //update
                    DB::table('loans')->where('id', '=', $id)->update($dataDefault);
                }
            }
        }

        

        return $loan->loan;
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
