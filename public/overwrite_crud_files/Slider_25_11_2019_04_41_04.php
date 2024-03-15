<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{

	   protected $table = 'slider';
	   public $primaryKey = 'id';
	   public $timestamps = true;
	   protected $fillable = ['title','subtitle','link','image','sort_order','status']; 
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
	    		
				if (empty($instance->sort_order)) {
		        $instance->sort_order=NULL;
		        }

				return $instance;
	    }	
	   
}