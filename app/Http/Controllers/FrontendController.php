<?php

namespace App\Http\Controllers;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class FrontendController extends Controller
{
        
		public function home(){

            return view('frontend.home');
        }


		public function about(){

            return view('frontend.about');
        }


		public function contact(){

            return view('frontend.contact');
        }


		public function service(){

            return view('frontend.service');
        }


		public function termcondition(){

            return view('frontend.termcondition');
        }


}