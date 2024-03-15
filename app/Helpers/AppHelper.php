<?php
namespace App\Helpers;
use Auth;
use Illuminate\Support\Facades\Storage;
class AppHelper
{
      
      
      public static function getStatus()
      {   
          
          return array(1=>'Active',0=>'Inactive');
      }

      public static function getAdminCompanyDetails($field_name="")
      {   
          $setting=\App\Setting::select($field_name)->latest()->first();    
          return !empty($setting[$field_name])?$setting[$field_name]:"";
      }

     public static function getAdminSettingImage($field_name="")
      {   
          $setting=\App\Setting::select($field_name)->latest()->first();    
          if(isset($setting[$field_name]) && !empty($setting[$field_name])){
            $logo=asset('public/storage/'.$setting[$field_name]);
          }else{
            $logo=asset("public/".config('constants.default_fav_icon'));
          }
          return $logo;
      }
    

      public static function getImage($image_path)
      {       
          if(isset($image_path) && !empty($image_path)){
            $image=asset('public/storage/'.$image_path);
          }else{
            // $image=asset("public/".Config::get('constants.default_image'));
            $image=asset("public/".config('constants.default_image'));
          }

             return $image;
      }
      public static function addLoginHistory()
      {      

          $add_login_history = \App\LoginHistory::create([
              'user_id'=>auth()->user()->id,
              'last_login_ip'=>"127.0.0.1",
              'last_login_location' =>"Vadodara",
             ]);

          return $add_login_history;
      }

      public static function getLastLogin()
      {       

        $last_login=\App\LoginHistory::where('user_id',auth()->user()->id)->latest()->first();
        return $last_login;
      }
      public static function getLoginHistory()
      {       

        $login_history=\App\LoginHistory::where('user_id',auth()->user()->id)->latest()->offset(0)->limit(10)->get()->toArray();
        return $login_history;
      }

      public static function getDateTimeFormat($date_time)
      {      
        if ($date_time=="0000-00-00 00:00:00" || empty($date_time)) {
           return "";
         }else{
          return date('d-m-Y h:i A',strtotime($date_time));
         } 
        
      }

      public static function getDateFormat($date)
      { 

            if ($date=="1000-01-01" || empty($date)) {
               return "";
             }else{
              return date('d-m-Y',strtotime($date));
             } 
        }
      public static function getTimeFormat($time)
      {  
          
          if ($time=="00:00:00" || empty($time)){
             return "";
           }else{
            return date('h:i A',strtotime($time));
           }    
        
      }
   
     public static function instance()
     {
         return new AppHelper();
     }
}