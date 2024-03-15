<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

	   protected $table = 'country';
	   public $primaryKey = 'id';
	   public $timestamps = true;
	   protected $fillable = ['name','status','sort_order']; 
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