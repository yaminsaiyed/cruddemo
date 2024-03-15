<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
class UserController extends Controller
{	

	public function __construct() {
   		$this->middleware('auth',['except' => array('login','login_submit','forgot_password','reset_password')]);
	}
   
	
	public function dashboard()
	{
		 return view('user.dashboard');
	}

	public function profile()
	{	
		$user_id=Auth::user()->id;
		$user = User::where('id',$user_id)->first()->toArray();
		$last_login=\AppHelper::getLastLogin();
		$login_history=\AppHelper::getLoginHistory();

  	    return view('user.profile',["user"=>$user,"last_login"=>$last_login,"login_history"=>$login_history]);
	}

	public function profile_submit(Request $request)
	{	

		$user_id=Auth::user()->id;

		$this->validate($request, [
		  'firstname'   => 'required',
		  'lastname'   => 'required',
		  'email'   => 'required|email|unique:users,email,' . $user_id,
		  'mobile'   => 'required|min:10|max:15|unique:users,mobile,'.$user_id,
		  'password'  => 'min:6',
		  // 'password'  => 'same:confirm_password',
		  'confirm_password'  => 'same:password',
		 ],
		 [
		    'firstname.required' => 'please enter firstname',
		    'lastname.required' => 'please enter lastname',
		    'email.required' => 'please enter email address',
		    'email.email' => 'please enter valid email address',
		    'email.unique' => 'email address already exist in system',
		    'mobile.required' => 'please enter mobile',
		    'mobile.min' => 'please enter valid mobile',
		    'mobile.max' => 'please enter valid mobile',
		    'mobile.unique' => 'mobile number already exist in system',
		    'password.min' => 'password should be atleast 6 character',
		    // 'password.same' => 'please enter match password',
		    'confirm_password.same' => 'please enter match password',
		   
		]);

		$user = User::find($user_id);
			
			if (!$request->filled('password')) {
	    		$request->request->remove('password');
			}else{
				$request->request->add(['password' =>Hash::make($request->request->get('password'))]);
			}
	
	
		if(User::where('id', $user_id)->update($request->except(['_token','confirm_password','_profile'])))
		{
			return redirect()->route('admin.profile')->with('success_message', 'Successfully Submitted');
		}else{
			return redirect()->route('admin.profile')->with('error_message', 'Opps Something Went Wrong');
		}
		
	}

	public function login()
	{	
		if (!Auth::guest()) {
           return redirect()->route('admin.dashboard');
    	}
    	

		return view('user.login');
	}

	public function login_submit(Request $request)
	{
	
		$this->validate($request, [
		  'email'   => 'required',
		  'password'  => 'required|min:6|max:20'
		 ],
		 [
		    'email.required' => 'please enter username or email address',
		    'password.required' => 'please enter password',
		   
		]);

		 $user_data_email = array(
		  'email'  => $request->get('email'),
		  'password' => $request->get('password'),
		  'status' => 1
		 );
		 $user_data_username = array(
		  'username'  => $request->get('email'),
		  'password' => $request->get('password'),
		  'status' => 1
		 );

		 if(Auth::attempt($user_data_email) || Auth::attempt($user_data_username))
		 {

		 	\AppHelper::addLoginHistory();
			
			return redirect()->route('admin.dashboard');

		 }
		 else
		 {
		  return back()->with('error_message', 'Username Or Password Was Incorrect');
		 }
	
	}
	public function forgot_password(Request $request)
	{	
		if (!Auth::guest()) {
           return redirect()->route('admin.dashboard');
    	}

		if ($request->isMethod('post')) {

				$this->validate($request, [
				  'email'   => 'required|email',
				 ],
				 [
				    'email.required' => 'please enter email address',
				    'email.email' => 'please enter valid email address',
				]);
				
				$email=$request->email;

				$user = User::where('email',$email)->first();
				if(!isset($user->id)) {
					return back()->with('error_message', '"'.$email.'" is not registered');			
				} 
				
				$name=$user->firstname." ".$user->lastname;
				$user_id=$user->id;
				
				$company_name=\AppHelper::getAdminCompanyDetails("company_name");

				$reset_token_hash=$user_id.md5(uniqid(rand(), true));
				$reset_datetime=date('Y-m-d H:i:s');

				$from=array('email'=>config('constants.from_email'),'name'=>config('constants.from_email_name'));
				
				$subject="Request your ".$company_name." password";
				$to=array($email=>$name);
				
				$data=array('name'=>$name,'reset_token_hash'=>$reset_token_hash);
				
				/* User::where('id', $user_id)->update(array('reset_token_hash'=>$reset_token_hash,'reset_datetime'=>$reset_datetime));
				return view('user.email_forgot_password',['data'=>$data]); */

				Mail::send(['html'=>'user.email_forgot_password'],['data'=>$data], function($message) use ($subject,$from,$to){
		        $message->from($from['email'],$from['name']);
  				$message->subject($subject);
		        foreach ($to as $to_email => $to_name) {
		         	$message->to($to_email, $to_name);	
		        }
				});

				 if (Mail::failures()) {
				   	return new Error(Mail::failures()); 
				 }else{
				 	User::where('id', $user_id)->update(array('reset_token_hash'=>$reset_token_hash,'reset_datetime'=>$reset_datetime));
				 	return redirect()->route('admin.login')->with('success_message', 'Please check your email for reset your password');
				 }


		}
		return view('user.forgot_password');
	}
	public function reset_password(Request $request,$reset_token_hash="")
	{
		if (!Auth::guest()) {
           return redirect()->route('admin.dashboard');
    	}
		$date=date("Y-m-d H:i:s",strtotime("-2 Hours"));
		$user=User::where(array(['reset_token_hash',"=",$reset_token_hash],['reset_datetime', '>=',$date]))->first();
		
		if (isset($user->id) && !empty($user->id)) {
			if ($request->isMethod('post')) {
			
			$this->validate($request, [
				  'password'   => 'required|min:6',
				  'confirm_password'  => 'required|same:password',
		   	 ],
			 [
			    'password.required' => 'please enter password',
			    'password.min' => 'password should be atleast 6 character',
			    'confirm_password.required' => 'please enter confirm password',
			    'confirm_password.same' => 'please enter match password',
		   
			  ]);

			 $password=Hash::make($request->request->get('password'));	
			 
			 if (User::where('id', $user->id)->update(array('password'=>$password,'reset_token_hash'=>NULL,'reset_datetime'=>NULL))) {
			 	
			 	return redirect()->route('admin.login')->with('success_message', 'password successfully updated');

			 }	

			}
			

			return view('user.reset_password',['reset_token_hash'=>$reset_token_hash]);
		}else {
			
			return redirect()->route('admin.forgot_password')->with('error_message', 'email verification link has expired. please enter your email address and we will send another verification link');
		}
		
	
		
	}
	public function logout()
    {

     Auth::logout();
     return redirect()->route('admin.login')->with('success_message', 'Successfully Logout');
     
    }

}
