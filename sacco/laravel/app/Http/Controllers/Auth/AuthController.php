<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Member;
use URL;
use DB;
use Session;
use View;
use Hash;
use Carbon\Carbon;
use Redirect;
use App\Loan;
use App\Installment;
use Response;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{

    
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }*/

    //for the log in redirect to the route bellow.
    protected $loginPath = '/';


    /**
     * Create Account.
     */
    public function create()
    {
        $title = 'Create Account.';

        //get all the users.
        $users = User::all();

        //get all the trashed users
        $trash = User::onlyTrashed()->get();

        //get todays time.
        $today = Carbon::now()->formatlocalized('%a %d %b %y');

        //get the current time.
        $currenttime = Carbon::now('Africa/Nairobi')->format('h:i a');

        return View('auth.createAccount', compact('users', 'trash', 'today', 'currenttime'))
            ->with('title', $title);
    }

    /**
     * Save a newly created resource in storage.
     */
    public function save(Request $request){

        //first is validation of all inputs.
        $this->validate($request, [
            'firstname'       => 'required',
            'lastname'        => 'required',
            'phoneNumber'     => 'required|unique:users|max:10|min:10',
            'idNumber'        => 'required|unique:users|max:8|min:8',
            'jobTitle'        => 'required',
            'emailAddress'    => 'required|unique:users|email',
            'username'        => 'required',
            'password'        => 'required',
            'confirmPassword' => 'required|same:password',
            ]);

        //check for any constrains.
        if ($request->fails) {
            # code...

            return redirect()->route('createAccount')
                ->withErrors($request)
                ->withInput();
        }
        else{

            //active by default is 0.
            $active = 0;

            //role is 0 by default.
            $role = 0;

            //manually play with the user pic.
            $userPic = 'Image Not Available for Now.';

            //code should be 60.
            $code = str_random(60);

            //hash my password.
            $pass = $request->get('password');

            $password = Hash::make($pass);

            
            $firstname    = $request->get('firstname');
            $lastname     = $request->get('lastname');
            $phoneNumber  = $request->get('phoneNumber');
            $idNumber     = $request->get('idNumber');
            $jobTitle     = $request->get('jobTitle');
            $emailAddress = $request->get('emailAddress');
            $username     = $request->get('username');

            //get all the trashed users
            $trash = User::onlyTrashed()->get();

            //get todays time.
            $today = Carbon::now()->formatlocalized('%a %d %b %y');

            //get the current time.
            $currenttime = Carbon::now('Africa/Nairobi')->format('h:i a');
            

            $title = 'Finish Up.';

            //get all the users.
            $users = User::all();

            return View('auth.finishAccount', 
                [
                    'firstname'    => $firstname,
                    'lastname'     => $lastname,
                    'phoneNumber'  => $phoneNumber,
                    'idNumber'     => $idNumber,
                    'jobTitle'     => $jobTitle,
                    'userPic'      => $userPic,
                    'emailAddress' => $emailAddress,
                    'username'     => $username,
                    'password'     => $password,
                    'active'       => $active,
                    'role'         => $role,
                    'code'         => $code,
                    'users'        => $users,
                    'trash'        => $trash,
                    'today'        => $today,
                    'currenttime'  => $currenttime,
                ])
                ->with('title', $title);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function storeAccount(Request $request)
    {
        //validation.
        $this->validate($request, [
            'file' => 'required|image',
            ]);
        if ($request->fails) {
            
            return redirect()->route('saveAccount')
                ->withErrors($request)
                ->withInput();
        }
        else {

            //retrieve all the data.
            $userPic = $request->file('file');

            $ext = $userPic->guessClientExtension(); // (Based on mime type)

            //get the original name of the photo.
            $filename = $userPic->getClientOriginalName();

            //get the file path and assign a variable to the same.
            $storagePath = 'uploads/' . Auth::user()->id. '/' . $filename;  

            //move the file to the uploads folder.
            $userPic->move($storagePath, $filename);

            //save the pic
            $savePic = '/uploads/' . Auth::user()->id .'/'. $filename.'/' .$filename;

            //get the username.
            $username = $request->get('username');

            //handle the slug.
            $slug = Str::slug($username);

            //create an object of the user class.
            $data = User::create([

                'firstname'    => $request->get('firstname'),
                'lastname'     => $request->get('lastname'),
                'phoneNumber'  => $request->get('phoneNumber'),
                'idNumber'     => $request->get('idNumber'),
                'jobTitle'     => $request->get('jobTitle'),
                'userPic'      => $savePic,
                'emailAddress' => $request->get('emailAddress'),
                'username'     => $request->get('username'),
                'password'     => $request->get('password'),
                'active'       => $request->get('active'),
                'role'         => $request->get('role'),
                'code'         => $request->get('code'),
                'slug'         => $slug,
            ]);

            //check whether data is saved first.
            if ($data) {
                # code...

                $firstname = $request->get('firstname');
                $code      = $request->get('code');

                Mail::send('mail.activate', ['link' => URL::route('activate', $code),
                    'firstname' => $firstname], function($message) use ($data){
                        $message ->to($data->emailAddress, $data->firstname)->subject('Activate Your Account.');
                });

                $response = 'User Account Created.';

                return $response;
            }
            else{

                return redirect()->route('create')
                    ->with('global', '<p style="20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-danger alert-dismissible" role="alert">' . 'Your Profile has not been created.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
            }  
        }  
    }

    /*
    * Handle the code for activation.
    */
    public function activate($code){

        //get the user who is not active and the code is there.
        //attach a variable to the same.
        $state = User::where('code','=',$code)->where('active','=',0);

        //count the records.
        if ($state->count()) {
            
            //get the first record.
            $state = $state->first();

            //empty the code.
            $state->code = '';

            //activate the user.
            $state->active = 1;

            //save and re route the user.
            if ($state->save()) {
                # code...
                return redirect()->route('login')
                -> with('global', '<p style="font:20px book antiqua; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-info alert-dismissible" role="alert">' . 'Your account has been Activated.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
            }
            else{

                return redirect()->route('login')
                -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-danger alert-dismissible" role="alert">' . 'We couldn\'t for some reason activate your account.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
            }
        }
    }
    
    /**
     * Login View
     */
    public function login()
    {
        $title = "Login.";

        return View('guest.login')
            ->with('title', $title);
    }

    /**
     * Sign in a user
     */
    public function access(Request $request){

        //validation.
        $this->validate($request, [
            'emailAddress' => 'required|email',
            'password'     => 'required'
            ]);

        if ($request->fails) {
            # code...

            return redirect()->route('login')
                ->withErrors($request)
                ->withInput();
        }
        else{

            if (!Auth::attempt($request->only(['emailAddress', 'password']))) {
                
                return redirect()->route('login')
                ->with('global', '<p style="font:20px book antiqua; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-danger alert-dismissible" role="alert">' . 'Ensure You\'ve Provided Correct Email and or Password.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
            }
            else{

                //get the active status of the user and assign the variable to the same.
                $active = Auth::user()->active;

                //get the role and assign a variable to the same.
                $role = Auth::user()->role;

                //role == 0 this is a normal user. If 1 its an admin.
                if ($role == 1 && $active == 1) {
                    
                    //log in the admin
                    return redirect()->route('dashboard')
                    -> with('global', '<p style="font:20px book antiqua; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-success alert-dismissible" role="alert">' . 'Welcome Administrator.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
                }
                else if($role == 2 && $active == 1) {

                    //log in the user.
                    return redirect()->to('prologue')
                    -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-success alert-dismissible" role="alert">' . 'You\'are Logged In.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
                }
            }
        }
    }

    /*
    * Log users out.
    */ 
    public function logout(){

        //logout the user.
        auth()->logout();

        //redirect the user.
        return redirect()->to('/')
        -> with('global', '<p style="font:20px book antiqua; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-info alert-dismissible" role="alert">' . 'Good Bye.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
    }

    /**
     * Forgot Password
     */
    public function forgot()
    {
        $title = 'Forgot Password.';

        return View('guest.forgotPass')
            ->with('title', $title);
    }

    /**
     * Change Password
     */
    public function storePass(Request $request){

        //validate the fields.
        $this->validate($request, [
            'emailAddress' => 'required|email'
            ]);

        //provide error messages appropriately.
        if ($request->fails) {
            # code...
            return redirect()->route('forgotPass')
                ->withErrors($request);
        }
        else{

            //get all the users input and assign it to a variable.
            $email = $request->get('emailAddress');

            $data = User::where('emailAddress','=',$email);

            //we then need to count and take the first email that we recognize.
            if ($data-> count()) {
                # code...
                $data = $data-> first();

                //then generate a new code & password and assign a variable to @.
                $password = str_random(10);
                $code     = str_random(60);

                //now we can assign our db data with the above ones.
                //we do so by accessing our model which holds this info.
                $data->passTemp = Hash::make($password);
                $data->code     = $code;
            
                //then we can save this info.
                if ($data->save()) {
                    # code... the email to be sent plus the password so as to enable our user recover his account.
                    Mail::send('mail.recover', ['link'=> URL::route('forgotPasswordCode',$code), 'username'=>$data->username, 'password'=> $password], function($message) use ($data) {
                        $message-> to($data->emailAddress, $data->username) ->subject('Your new password.');
                    });

                    return Redirect::route('login')
                    -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-info alert-dismissible" role="alert">' . 'Check Your Email Account.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
                }
                else{

                    return Redirect::route('forgotPass')
                    -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-danger alert-dismissible" role="alert">' . 'Incorrect Email Account Provided.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
                }
            }
        }
        
        return Redirect::route('forgotPass')
        -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-warning alert-dismissible" role="alert">' . 'Email Account Provided Does\'nt Exist.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
    }

    /**
     * Forgot Code
     */
    public function forgotCode($code){

        //first through our model we need to ensure that the code passed via mail is the same 
        //as the one existing in our db. Then we need to also make sure that our password_temp
        //in out db is not null.
        $data = User::where('code','=',$code)
        -> where('passTemp','!=','');

        //we need to ensure that the above exists in our db through count, then select the first one.
        if ($data-> count()) {
            # code...
            $data = $data-> first();

            //get the password temporary and replace as the actual password.
            $passTemp = $data->passTemp;

            //then the password_temp should be == password in our db.
            //empty our password_temp
            //empty our code.
            $data->password = $passTemp;
            $data->passTemp = '';
            $data->code     = '';

            //now we can save this info and reroute accordingly.
            if ($data-> save()) {
                # code...
                return Redirect::route('login')
                -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-success alert-dismissible" role="alert">' . ' Your Account has been recovered' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
            }
            else
            {
                //incase of an error.
                return Redirect::route('login')
                -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-warning alert-dismissible" role="alert">' . ' We could\'nt Recover your Account.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
            }
        }
        //incase of an error.
            return Redirect::route('login')
            -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-warning alert-dismissible" role="alert">' . ' Your Account is already Active.' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
    }

    /**
    * Change Password
    **/
    public function passChange($id){

        $user = User::find($id);

        $title = 'Change Password.';

         //get the current time.
        $currenttime = Carbon::now('Africa/Nairobi')->format('h:i a');

        //get todays time.
        $today = Carbon::now()->formatlocalized('%a %d %b %y');

        //get all the trashed users
        $trash = User::onlyTrashed()->get();

        return View('auth.changePassword', compact('user', 'currenttime', 'today', 'trash'))
            ->with('title', $title);
    }

    /**
    * Store Password
    **/
    public function storePassword(Request $request, $id){

        //validation.
        $this->validate($request, [
            'oldPassword'  => 'required',
            'newPassword'  => 'required',
            'redoPassword' => 'required|same:newPassword'
            ]);

        //incase of failure.
        if ($request->fails) {
            # code...
            return redirect()->route('passChange')
                ->withErrors($request);
        }
        else{

            //get the password that belongs to this user.            
            $user = User::find($id);

            //get the old password's input from the user.
            $oldPassword = $request->get('oldPassword');

            //get the new password.
            $newPassword = $request->get('newPassword');

            //ensure that we communicate incase the user trys to replace a password with an 
            //existing one.

            if(Hash::check($oldPassword, $user-> getAuthPassword())) {
                
                //now we need to access our model the password fieldname & hash our new password.
                $user->password = Hash::make($newPassword);

                //finally we need to save this and reroute our user accordingly.
                if ($user-> save()) {
                    # code...                       
                    
                    return redirect()->route('dashboard')
                    -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-success alert-dismissible" role="alert">' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . 'You\'ve Changed Your Password.' . '</p>');  
                }
                else{

                    return redirect()->route('passChange', $id)
                    -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; width:100%; text-align:center" class="alert alert-warning alert-dismissible" role="alert">' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . 'Something Went Wrong.' . '</p>');
                }
            }
            else {
                return Redirect::route('passChange', $id)
                -> with('global', '<p style="font:20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-warning alert-dismissible" role="alert">' . 'Your Current Password Is Incorrect' . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . '</p>');
            }
            
        }
    }
}
