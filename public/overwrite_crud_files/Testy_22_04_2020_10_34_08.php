<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testy extends Model
{

	   protected $table = 'testy';
	   public $primaryKey = 'id';
	   public $timestamps = true;
	   protected $fillable = ['name','date_test','time_test','long_text_test','image','status','sort_order']; 
	   protected $guarded = array();

	   
	   
	   
	   	public static function boot() {
	       parent::boot();

			static::creating(function ($instance){
		        self::before_save_update($instance);
			});
			static::updating(function ($instance){
		        self::before_save_update($instance);
			});
	    }

	    public static function before_save_update($instance)
	    {
	    		
				if (empty($instance->date_test)) {
		        $instance->date_test="1000-01-01";
		        }else{
		        $instance->date_test=date("Y-m-d",strtotime($instance->date_test));
		        }
				if (empty($instance->time_test)) {
		        $instance->time_test="00:00:00";
		        }else{
		        $instance->time_test=date("h:i:s",strtotime($instance->time_test));
		        }
				if (empty($instance->sort_order)) {
		        $instance->sort_order=NULL;
		        }

				return $instance;
	    }	
	   
}