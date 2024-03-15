<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

	   protected $table = 'state';
	   public $primaryKey = 'id';
	   public $timestamps = true;
	   protected $fillable = ['country_id','name','status','sort_order']; 
	   protected $guarded = array();

	   
			public function get_country()
		{
			return $this->belongsTo('App\Country', 'country_id', 'id');
		}
	   
	   
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