<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use App\Setting;
use App\User;

class SettingController extends Controller
{
    public function __construct() {
   		$this->middleware('auth',['except' => array()]);
	}
	
	function create_tenant() : void {
		
		$name='a';
		$email='abcd@gmail.com';
		
		$tenant=\App\Tenant::create([
			'name'=>$name,
			'email'=>$email,
			'password'=>"123456",
		]);
		
		$tenant->domains()->create([
			'domain'=>$name.".".config('app.domain')
		]);
		echo "success";
	}

	function index()
	{
		
		$result = Setting::where('id',1)->first()->toArray();
		return view('setting.index',["result"=>$result]);
	}

	function setting_submit(Request $request)
	{
		$this->validate($request, [
		  'company_name'   => 'required',
		  'company_phone'   => 'required|min:10|max:15',
		  'company_email'   => 'required|email',
		  'company_address'  => 'required',
		 ],
		 [
		    'company_name.required' => 'please enter company name',
		    'company_phone.required' => 'please enter company phone number',
		    'company_phone.required' => 'please enter mobile',
		    'company_phone.min' => 'please enter valid mobile',
		    'company_phone.max' => 'please enter valid mobile',
		    'company_email.required' => 'please enter email address',
		    'company_email.email' => 'please enter valid email address',
		    'company_address.required' => 'please enter company address',
		   
		]);


		if(Setting::where('id', 1)->update($request->except(['_token','_company_logo','_company_fav'])))
		{

			return redirect()->route('setting')->with('success_message', 'Successfully Submitted');
		}else{
			return redirect()->route('setting')->with('error_message', 'Opps Something Went Wrong');
		}

		
	}
	public function unauthorized()
	{
		return view('setting.unauthorized');
	}
}
