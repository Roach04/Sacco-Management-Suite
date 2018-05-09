<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use DB;
use Carbon\Carbon;
use App\User;
use App\Member;
use App\Account;
use App\Loan;
use App\Installment;
use Illuminate\Support\Str;
use Auth;
use PDF;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class MemberController extends Controller
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
        
        //get the last sacco day of loan repayments.
        $lastDay = Carbon::now()->endOfMonth()->subDays(13);

        //estimate a time period when a member has already defaulted.
        $estimate = Carbon::now()->endOfMonth()->subDays(13)->addDays(4);

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
    ** Origin.
    **/
    public function index()
    {
        $title = 'Members Accounts.';

        /* loans. */
        $loan = Loan::where('state', '=', 1);
        
        return View('auth.members.members')
            ->with('title', $title);
              
        /* loans. */
    }

    /**
     * Create new members.
     */
    public function create()
    {
        //get the title.
        $title = 'Create Members.';

        return View('auth.members.createMember')
            ->with('title', $title);
    }

    /**
     * Save Members.
     */
    public function save(Request $request)
    {
        //validation.
        //first is validation of all inputs.
        $this->validate($request, [
            'firstname'         => 'required',
            'surname'           => 'required',
            'lastname'          => 'required',
            'accountType'       => 'required',
            'maritalStatus'     => 'required',
            'occupation'        => 'required',
            'gender'            => 'required',
            'bankName'          => 'required',
            'bankAccountName'   => 'required',
            'bankAccountNumber' => 'required',
            'phoneNumber'       => 'required|max:10|min:10',
            'idNumber'          => 'required|max:8|min:8',
            'dateOfBirth'       => 'required',
            'emailAddress'      => 'required|email',
            'poBox'             => 'required',
            'county'            => 'required',
            'nationality'       => 'required',
            'firstnameKin'      => 'required',
            'surnameKin'        => 'required',
            'lastnameKin'       => 'required',
            'maritalStatusKin'  => 'required',
            'occupationKin'     => 'required',
            'genderKin'         => 'required',
            'relationshipKin'   => 'required',
            'phoneNumberKin'    => 'required|max:10|min:10',
            'idNumberKin'       => 'required|max:8|min:8',
            'dateOfBirthKin'    => 'required',
            'emailAddressKin'   => 'required|email',
            'poBoxKin'          => 'required',
            'countyKin'         => 'required',
            'nationalityKin'    => 'required',
            ]);

        //check for any constrains.
        if ($request->fails) {
            # code...

            return redirect()->route('createMember')
                ->withErrors($request)
                ->withInput();
        }
        else{
            
            $firstname         = $request->get('firstname');
            $surname           = $request->get('surname');
            $lastname          = $request->get('lastname');
            $accountType       = $request->get('accountType');
            $maritalStatus     = $request->get('maritalStatus');
            $occupation        = $request->get('occupation');
            $gender            = $request->get('gender');
            $bankName          = $request->get('bankName');
            $bankAccountName   = $request->get('bankAccountName');
            $bankAccountNumber = $request->get('bankAccountNumber');
            $phoneNumber       = $request->get('phoneNumber');
            $idNumber          = $request->get('idNumber');
            $dateOfBirth       = $request->get('dateOfBirth');
            $emailAddress      = $request->get('emailAddress');
            $poBox             = $request->get('poBox');
            $county            = $request->get('county');
            $nationality       = $request->get('nationality');

            //next of kin.
            $firstnameKin     = $request->get('firstnameKin');
            $surnameKin       = $request->get('surnameKin');
            $lastnameKin      = $request->get('lastnameKin');
            $maritalStatusKin = $request->get('maritalStatusKin');
            $occupationKin    = $request->get('occupationKin');
            $genderKin        = $request->get('genderKin');
            $relationshipKin  = $request->get('relationshipKin');
            $phoneNumberKin   = $request->get('phoneNumberKin');
            $idNumberKin      = $request->get('idNumberKin');
            $dateOfBirthKin   = $request->get('dateOfBirthKin');
            $emailAddressKin  = $request->get('emailAddressKin');
            $poBoxKin         = $request->get('poBoxKin');
            $countyKin        = $request->get('countyKin');
            $nationalityKin   = $request->get('nationalityKin');

            //get all the trashed users
            $trash = User::onlyTrashed()->get();

            //get todays time.
            $today = Carbon::now()->formatlocalized('%a %d %b %y');

            //get the current time.
            $currenttime = Carbon::now('Africa/Nairobi')->format('h:i a');

            $title = 'Finish Up.';

            return View('auth.members.storeMember', 
                [
                    'firstname'         => $firstname,
                    'surname'           => $surname,
                    'lastname'          => $lastname,
                    'accountType'       => $accountType,
                    'maritalStatus'     => $maritalStatus,
                    'occupation'        => $occupation,
                    'gender'            => $gender,
                    'bankName'          => $bankName,
                    'bankAccountName'   => $bankAccountName,
                    'bankAccountNumber' => $bankAccountNumber,
                    'phoneNumber'       => $phoneNumber,
                    'idNumber'          => $idNumber,
                    'dateOfBirth'       => $dateOfBirth,
                    'emailAddress'      => $emailAddress,
                    'poBox'             => $poBox,
                    'county'            => $county,
                    'nationality'       => $nationality,
                    'firstnameKin'      => $firstnameKin,
                    'surnameKin'        => $surnameKin,
                    'lastnameKin'       => $lastnameKin,
                    'maritalStatusKin'  => $maritalStatusKin,
                    'occupationKin'     => $occupationKin,
                    'genderKin'         => $genderKin,
                    'relationshipKin'   => $relationshipKin,
                    'phoneNumberKin'    => $phoneNumberKin,
                    'idNumberKin'       => $idNumberKin,
                    'dateOfBirthKin'    => $dateOfBirthKin,
                    'emailAddressKin'   => $emailAddressKin,
                    'poBoxKin'          => $poBoxKin,
                    'countyKin'         => $countyKin,
                    'nationalityKin'    => $nationalityKin,
                    'trash'             => $trash,
                    'today'             => $today,
                    'currenttime'       => $currenttime,
                ])
                ->with('title', $title);
        }
    }

    /**
     * Store a newly created member
     */
    public function store(Request $request)
    {
        //retrieve all the data.
        $userPic = $request->file('file');

        $ext = $userPic->guessClientExtension(); // (Based on mime type)

        //get the original name of the photo.
        $filename = $userPic->getClientOriginalName();

        //get the file path and assign a variable to the same.
        $storagePath = 'uploads/members/' . Auth::user()->id. '/' . $filename;  

        //move the file to the uploads folder.
        $userPic->move($storagePath, $filename);

        //save the pic
        $savePic = '/uploads/members/' . Auth::user()->id .'/'. $filename.'/' .$filename;

        //get the username.
        $lastname = $request->get('lastname');

        //handle the slug.
        $slug = Str::slug($lastname);

        //ensure that members do exist first.
        if (count(Auth::user()->members)) {
            
            //handle the account number thingy.
            $record = Auth::user()->members()->latest()->first();

            $access = $record->accountNumber;
            
            if(count($access)){

                $accountNumber = str_pad($access + 1, 4, 0, STR_PAD_LEFT);
            }   
            else{

                $access = 0000;

                $accountNumber = str_pad($access + 1, 4, 0, STR_PAD_LEFT);
            }
        }
        else {

            $access = 0000;

            $accountNumber = str_pad($access + 1, 4, 0, STR_PAD_LEFT);
        }

        

        

        //create an object of the user class.
        $data = Auth::user()->members()->create([

            'accountNumber'     => $accountNumber,
            'firstname'         => $request->get('firstname'),
            'surname'           => $request->get('surname'),
            'lastname'          => $request->get('lastname'),
            'accountType'       => $request->get('accountType'),
            'maritalStatus'     => $request->get('maritalStatus'),
            'occupation'        => $request->get('occupation'),
            'gender'            => $request->get('gender'),
            'bankName'          => $request->get('bankName'),
            'bankAccountName'   => $request->get('bankAccountName'),
            'bankAccountNumber' => $request->get('bankAccountNumber'),
            'phoneNumber'       => $request->get('phoneNumber'),
            'idNumber'          => $request->get('idNumber'),
            'dateOfBirth'       => $request->get('dateOfBirth'),
            'emailAddress'      => $request->get('emailAddress'),
            'poBox'             => $request->get('poBox'),
            'county'            => $request->get('county'),
            'nationality'       => $request->get('nationality'),
            'memberPic'         => $savePic,
            'slug'              => $slug,
            'idNumberKin'       => $request->get('idNumberKin'),
            'dateOfBirthKin'    => $request->get('dateOfBirthKin'),
            'firstnameKin'      => $request->get('firstnameKin'),
            'surnameKin'        => $request->get('surnameKin'),
            'lastnameKin'       => $request->get('lastnameKin'),
            'maritalStatusKin'  => $request->get('maritalStatusKin'),
            'occupationKin'     => $request->get('occupationKin'),
            'genderKin'         => $request->get('genderKin'),
            'relationshipKin'   => $request->get('relationshipKin'),
            'phoneNumberKin'    => $request->get('phoneNumberKin'),
            'emailAddressKin'   => $request->get('emailAddressKin'),
            'poBoxKin'          => $request->get('poBoxKin'),
            'countyKin'         => $request->get('countyKin'),
            'nationalityKin'    => $request->get('nationalityKin'),
            
        ]);

        //create an instance of the account model and automatically create accounts..
        /*$account = new Account;
        $account->member_id = $data->id;
        $account->save();*/

        //check whether data is saved first.
        if ($data) {
            # code...

            $firstname = $request->get('firstname');

            Mail::send('mail.memberCreate', ['firstname' => $firstname], function($message) use ($data){
                $message ->to($data->emailAddress, $data->firstname)->subject('Welcome to Sacco Dev.');
            });

            $response = strtoupper($firstname).'\'s'.' Account Created Successfully.';

            return $response;
        }
        else{

            return redirect()->route('create')
                ->with('global', '<p style="20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-danger alert-dismissible" role="alert">' . 'Your Profile has not been created.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
        }        
    }

    /**
     * Trash a member.
     */
    public function trashMember($id)
    {
        //trash a member.
        //get the member by id
        $member = Member::find($id);

        //get the names of the member.
        $fname = $member->firstname;
        $lname = $member->lastname;

        $member->delete();

        //re direct accordingly.
        return redirect()->back()
            -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-warning alert-dismissible" role="alert">' . $fname .' '. $lname. ' ' .'Trashed Succefully.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 

    }

    /**
     * show trashed projects.
     */
    public function trashed()
    {
        $title = 'Trashed Projects.';

        //gain access to the users.
        $members = Member::all();

        return View('auth.members.trashedMembers', compact('members'))
            ->with('title', $title);
    }

    /**
     * Restore a single member account.
     */
    public function restore($id)
    {
        //restore a single trashed member's account.
        $project = Member::whereId($id)
                ->onlyTrashed()->restore();

        //get the entire record based on the provided id.
        $data = Member::find($id);

        //get the firstname.
        $fname = $data->firstname;

        //get the lastname.
        $lname = $data->lastname;

        //get trashed members.
        $trashMember = Member::onlyTrashed()->get();

        //get all the trashed members.
        if (count($trashMember)>0) {
            
            //re direct accordingly.
            return redirect()->back()
                -> with('global', '<p style="font:bold 20px book antiqua; width:100%; padding:30px; margin-top:-20px; text-align:center" class="alert alert-info alert-dismissible" role="alert">' . $fname . ' '. $lname .' Restored Succefully.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
        }
        else{

            //re direct accordingly.
            return redirect()->route('memberAccount')
                -> with('global', '<p style="font:bold 20px book antiqua; width:100%; padding:30px; margin-top:-20px; text-align:center" class="alert alert-info alert-dismissible" role="alert">' . $fname . ' '. $lname .' Restored Succefully.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
        }         
    }

    /**
     * Restore all members' accounts.
     */
    public function restoreAll()
    {
        //restore a single trashed member's account.
        Auth::user()->members()->onlyTrashed()->restore();

        //re direct accordingly.
        return redirect()->route('memberAccount')
            -> with('global', '<p style="font:bold 20px book antiqua; width:100%; padding:30px; margin-top:-20px; text-align:center" class="alert alert-info alert-dismissible" role="alert"> Members Restored Succefully.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
                
    }

    /**
     * Fixed account holders.
     */
    public function fixed()
    {
        
        $title = 'Fixed Accounts.';

        //get all members whose accounts are fixed.
        $fixed = Member::where('accountType', '=', 'fixed')->get();

        //get todays time.
        $today = Carbon::now()->formatlocalized('%d %b %y');

        return View('auth.members.fixed', compact('fixed', 'today'))
            ->with('title', $title);                
    }

    /**
     * Savings account holders.
     */
    public function savings()
    {
        
        $title = 'Savings Accounts.';

        //get all members whose accounts are fixed.
        $savings = Member::where('accountType', '=', 'savings')->get();

        //get todays time.
        $today = Carbon::now()->formatlocalized('%d %b %y');

        return View('auth.members.savings', compact('savings', 'today'))
            ->with('title', $title);                
    }

    /**
     * Asset account holders.
     */
    public function asset()
    {
        
        $title = 'Asset Accounts.';

        //get all members whose accounts are asset.
        $asset = Member::where('accountType', '=', 'assets')->get();

        //get todays time.
        $today = Carbon::now()->formatlocalized('%d %b %y');

        return View('auth.members.asset', compact('asset', 'today'))
            ->with('title', $title);                
    }

    /**
     * Update Moneys of each member.
     */
    public function moneys(Request $request, $id)
    {
        //validate the inputs.
        $this->validate($request, [

            'money' => 'required',
            'bank'  => 'required'        
        ]);

        if ($request->fails) {
            
            //return the response.
            return response()->json(['failure' => 'All Field(s) Are Required.']);
        }
        else{

            //get the data and assign an array to the same.
            $data = [

                'money' => $request->money,
                'bank'  => $request->bank
            ];

            $account = new Account($data);

            $member = Member::find($id);

            $lname = $member->lastname;

            $member->account()->save($account);

            /*
            ** Update the member's totals field.
            */
            
            $member = Member::where('id', '=', $id);

            //get the totals field in add to the member's money as its being credited.
            $totalMoney = DB::table('members')->where('id', '=', $id)->pluck('totals');

            $aggregate = $totalMoney + $request->money;

            //get the data and field name into an array for updates.
            $dataTotal = [

                'totals' => $aggregate,
            ];

            //update the table.
            $member->update($dataTotal);            

            return response()->json(['response' => $lname. '\'s'. ' Account Credited Successfully.'], 200);
        }
    }

    /**
     * Update Member Account Details view.
     */
    public function edit(Request $request, $id) {

        $title = 'Member Updates.';

        //pass in the data via id.
        $member = Member::find($id);

        $accounts = DB::table('accounts')->where('member_id', $id)->count();

        if ($accounts) {
            
            // This will hold the count for you
            $cash = $member->account()->sum('money');

            //get the totals field in add to the member's money as its being credited.
            $cash = DB::table('members')->where('id', '=', $id)->pluck('totals');

            $time = $member->account()->latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');

            return View('auth.members.memberUpdates', compact('member', 'cash', 'last', 'accounts'))
                ->with('title', $title);
        }
        else{

            return View('auth.members.memberUpdates', compact('member','accounts'))
                ->with('title', $title);
        }
    }

    /**
    ** Update Member Account Details.
    **/
    public function update(Request $request, $id)
    {
        
        //first is validation of all inputs.
        $this->validate($request, [
            'firstname'         => 'required',
            'surname'           => 'required',
            'lastname'          => 'required',
            'accountType'       => 'required',
            'maritalStatus'     => 'required',
            'occupation'        => 'required',
            'gender'            => 'required',
            'bankName'          => 'required',
            'bankAccountName'   => 'required',
            'bankAccountNumber' => 'required',
            'phoneNumber'       => 'required|max:10|min:10',
            'idNumber'          => 'required|max:8|min:8',
            'dateOfBirth'       => 'required',
            'emailAddress'      => 'required|email',
            'poBox'             => 'required',
            'county'            => 'required',
            'nationality'       => 'required',
            'firstnameKin'      => 'required',
            'surnameKin'        => 'required',
            'lastnameKin'       => 'required',
            'maritalStatusKin'  => 'required',
            'occupationKin'     => 'required',
            'genderKin'         => 'required',
            'relationshipKin'   => 'required',
            'phoneNumberKin'    => 'required|max:10|min:10',
            'idNumberKin'       => 'required|max:8|min:8',
            'dateOfBirthKin'    => 'required',
            'emailAddressKin'   => 'required|email',
            'poBoxKin'          => 'required',
            'countyKin'         => 'required',
            'nationalityKin'    => 'required',
            ]);

        if($request->fails){

            return redirect()->route('memberUpdate', $id)
                ->withInput()
                ->withErrors($request);
        }
        else{

            //get all the data and assign a variable to the same.
            $data = [

                'firstname'         => $request->firstname,
                'surname'           => $request->surname,
                'lastname'          => $request->lastname,
                'accountType'       => $request->accountType,
                'maritalStatus'     => $request->maritalStatus,
                'occupation'        => $request->occupation,
                'gender'            => $request->gender,
                'bankName'          => $request->bankName,
                'bankAccountName'   => $request->bankAccountName,
                'bankAccountNumber' => $request->bankAccountNumber,
                'phoneNumber'       => $request->phoneNumber,
                'idNumber'          => $request->idNumber,
                'dateOfBirth'       => $request->dateOfBirth,
                'emailAddress'      => $request->emailAddress,
                'poBox'             => $request->poBox,
                'county'            => $request->county,
                'nationality'       => $request->nationality,

                'firstnameKin'      => $request->firstnameKin,
                'surnameKin'        => $request->surnameKin,
                'lastnameKin'       => $request->lastnameKin,
                'maritalStatusKin'  => $request->maritalStatusKin,
                'occupationKin'     => $request->occupationKin,
                'genderKin'         => $request->genderKin,
                'relationshipKin'   => $request->relationshipKin,
                'phoneNumberKin'    => $request->phoneNumberKin,
                'idNumberKin'       => $request->idNumberKin,
                'dateOfBirthKin'    => $request->dateOfBirthKin,
                'emailAddressKin'   => $request->emailAddressKin,
                'poBoxKin'          => $request->poBoxKin,
                'countyKin'         => $request->countyKin,
                'nationalityKin'    => $request->nationalityKin,
            ];

            $firstname = $request->firstname;

            $lastname  = $request->lastname;

            //update the data and re route accordingly.
            $save = DB::table('members')->where('id', '=', $id)
                    ->update($data);

            if ($save) {
                
                return redirect()->route('memberAccount')
                -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-warning alert-dismissible" role="alert">' . $firstname .' '. $lastname. ' ' .'Updated Succefully.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
            }
            else{

                return redirect()->route('memberUpdate', $id)
                -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-danger alert-dismissible" role="alert">' . $firstname .' '. $lastname. ' ' .'Updates Failed.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>'); 
            }
        }
    }

    /**
    ** Member statement.
    **/
    public function memberStatement(Request $request, $id) {

        $title = 'Member Statement.';

        //find the member in qn via id.
        $member = Member::find($id);

        //we need to get total deposits of each member.
        $deposits = $member->account()->sum('money');

        //gain access to all loans.
        //then search if the current member is a guarantor of either to the loans in qn.
        $loans = Loan::where('member_id', '=', $id)->get();

        //grab the account number of the member.
        $acc = $member->accountNumber;

        //grab the loans of which this member has guaranteed.
        $guaranteed = Loan::where('guaranteeOne', '=', $acc)
                    ->orWhere('guaranteeTwo', '=', $acc)
                    ->orWhere('guaranteeThree', '=', $acc)->get();

        //do a summation of all the loans.
        $sumLoans = Loan::where('member_id', '=', $id)->where('state', '>=', 1)->sum('amount');

        return View('auth.members.memberStatement', compact('guaranteed', 'sumLoans', 'member', 'loaner', 'loans', 'deposits'))
            ->with('title', $title);
    }

    /**
    ** PDF Member statement.
    **/
    public function pdfmemberStatement(Request $request, $id) {

        $title = 'PDF Member Statement.';

        //find the member in qn via id.
        $member = Member::find($id);

        //gain access to all loans.
        //then search if the current member is a guarantor of either to the loans in qn.
        $loans = Loan::where('member_id', '=', $id)->get();

        //grab the account number of the member.
        $acc = $member->accountNumber;

        //grab the loans of which this member has guaranteed.
        $guaranteed = Loan::where('guaranteeOne', '=', $acc)
                    ->orWhere('guaranteeTwo', '=', $acc)
                    ->orWhere('guaranteeThree', '=', $acc)->get();

        //do a summation of all the loans.
        $sumLoans = Loan::where('member_id', '=', $id)->where('state', '>=', 1)->sum('amount');
        
        $pdf = PDF::loadView('pdf.memberStatementPdf', compact('guaranteed', 'sumLoans', 'member', 'loans'))->setPaper('a3', 'portrait');

        return $pdf->stream('Member Statement.pdf');
    }

    /**
     * Edit Members' Money.
    **/
    public function money($id) {

        $title = 'Money Updates.';

        $member = Member::find($id);

        //get the accounts of a single member.
        $accounts = $member->account()->orderBy('created_at', 'desc')->paginate(10);

        //count to see if there is a record in our accounts table.
        $count = $accounts->count();

        if ($count != null) {
            
            //get the last record provided to the table accounts.
            $time = $member->account()->latest()->first();

            //get the total cash of the above member.
            $cash = $member->account()->sum('money');

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');

            return View('auth.members.moneyUpdates', compact('user', 'accounts', 'last', 'cash'))
                ->with('title', $title);
        }
        else {

            return View('auth.members.moneyUpdates', compact('user', 'accounts', 'cash'))
                ->with('title', $title);
        }        
    }

    /**
     * Store Members' Money.
    **/
    public function moneyStore(Request $request){

        $this->validate($request, [
            'credit' => 'required'
            ]);

        if ($request->fails) {
            
            return response()->json([ 'error' => 'Your Values Are Empty.' ]);
        }
        else{

            //get the input from our modal.
            $id       = $request['id'];
            $memberId = $request['memberId'];
            $credit   = $request['credit'];

            //get the money in the database.
            $record = Account::where('id', '=', $id)->first();

            $mon = $record->money;

            //get the total amount of money by the specified account holder.
            $cash = Account::where('member_id', '=', $memberId)->sum('money');

            if ($cash < 0) {
                
                return response()->json([ 'failure' => 'Member\'s Account is Empty' ], 200);
            }
            else if($credit < 0) {

                return response()->json([ 'failure' => 'Negative Entries Denied' ], 200);
            }
            else if($mon == $credit) {

                return response()->json([ 'failure' => 'No Updates Recorded' ], 200);
            }
            else {

                //then find the account by id.
                $account = Account::where('id', '=', $id);

                //access the field names to be updated from our table.
                $data = [

                    'money' => $credit,
                ];

                //update the table.
                $account->update($data);

                /*
                ** Update the member's totals field.
                */
                
                $member = Member::where('id', '=', $memberId);

                //get the totals field and add to the member's money as its being credited.
                $totalMoney = DB::table('members')->where('id', '=', $memberId)->pluck('totals');

                $aggregate = $totalMoney + $credit;

                //get the data and field name into an array for updates.
                $dataTotal = [

                    'totals' => $aggregate,
                ];

                //update the table.
                $member->update($dataTotal);

                if ($account) {
                    
                    return response()->json(['response' => 'Member\'s Account Updated Successfully.' ], 200);
                }
                else{

                    return response()->json(['failure' => 'Member\'s Account Updates Failed.' ], 200);
                }
            }            

            return response()->json([ 'failure' => 'An Error Has Occurred.' ], 200);
        }
    }

    /**
    ** Members Accounts Reconcile.
    **/
    public function reconcileAccounts() {

        $title = 'Members Reconciliation';

        //get the savings via id.
        $accounts = Account::orderBy('created_at', 'desc')->paginate(10);

        //summations of all the members contributions.
        $cash = $accounts->sum('money');

        $prop = $accounts->count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Account::latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');

            return View('auth.members.reconcileAccounts', compact('accounts', 'cash', 'last'))
                ->with('title', $title);
        }
        else {

            return View('auth.members.reconcileAccounts', compact('accounts', 'cash'))
                ->with('title', $title);
        }
    }

    /**
    ** Members Accounts Reconcile 3 Months.
    **/
    public function three() {

        $title = '3 Months Reconcile.';

        //get today.
        $today = Carbon::now();

        //minus 3 months from today.
        $minusThirty = $today->subMonth(1);

        //get the accounts with the correct time frame of 3 months
        $accounts = Account::where('updated_at', '>=', $minusThirty)->orderBy('created_at', 'desc')->paginate(10);

        // This will hold the count for you
        $cash = $accounts->sum('money');

        //count the records in the accounts table to see if there is any record.
        $prop = Account::count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Account::latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.members.reconcileAccountsThree', compact('accounts', 'last', 'cash'))
                ->with('title', $title);
        }
        else {

            return View('auth.members.reconcileAccountsThree', compact('accounts'))
            ->with('title', $title);
        }
    }

    /**
    ** Members Accounts Reconcile 6 Months.
    **/
    public function six() {
        
        $title = '6 Months Reconcile.';

        //get today.
        $today = Carbon::now();

        //minus 6 months from today.
        $minusSixty = $today->subMonth(6);

        //get the accounts with the correct time frame of 6 months
        $accounts = Account::where('updated_at', '>=', $minusSixty)->orderBy('created_at', 'desc')->paginate(10);

        // This will hold the count for you
        $cash = $accounts->sum('money');

        //count the records in the accounts table to see if there is any record.
        $prop = Account::count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Account::latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.members.reconcileAccountsSix', compact('accounts', 'last', 'cash'))
                ->with('title', $title);
        }
        else {

            return View('auth.members.reconcileAccountsSix', compact('accounts'))
                ->with('title', $title);
        }
    }

    /**
    ** Members Accounts Reconcile 12 Months.
    **/
    public function twelve() {
        
        $title = '12 Months Reconcile.';

        //get today.
        $today = Carbon::now();

        //minus 12 months from today.
        $minusTwelve = $today->subMonth(12);

        //get the accounts with the correct time frame of 12 months
        $accounts = Account::where('updated_at', '>=', $minusTwelve)->orderBy('created_at', 'desc')->paginate(10);

        // This will hold the count for you
        $cash = $accounts->sum('money');

        //count the records in the accounts table to see if there is any record.
        $prop = Account::count();

        //get the count on savings table.
        if ($prop != null) {
            
            $time = Account::latest()->first();

            //check the last updates.
            $last = $time->updated_at->formatLocalized('%a %d %b %y');
        
            return View('auth.members.reconcileAccountsTwelve', compact('accounts', 'last', 'cash'))
                ->with('title', $title);
        }
        else {

            return View('auth.members.reconcileAccountsTwelve', compact('accounts'))
                ->with('title', $title);
        }
    }

    /**
    ** Members Json
    **/
    public function membersJson() {

        //get all members.
        $members  = Member::all();

        //get the deposits
        $accounts = Account::all();

        //get the percentage of members that are active.
        $percentage = count($members) / 100;

        //return the above members in json.
        return response()->json([ 'laravel' => $members, 'accounts' => $accounts, 'percentage' => $percentage ], 200);
    }
}
