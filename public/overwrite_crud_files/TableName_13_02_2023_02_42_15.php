<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableName extends Model
{

	   protected $table = 'tablename';
	   public $primaryKey = 'id';
	   public $timestamps = true;
	   protected $fillable = ['name','description','long_description','very_long_description','date','time','datetime','price','country_id','image','status','sort_order']; 
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
	    		
				if (empty($instance->date)) {
		        $instance->date="1000-01-01";
		        }else{
		        $instance->date=date("Y-m-d",strtotime($instance->date));
		        }
				if (empty($instance->time)) {
		        $instance->time="00:00:00";
		        }else{
		        $instance->time=date("h:i:s",strtotime($instance->time));
		        }
				if (empty($instance->country_id)) {
		        $instance->country_id=NULL;
		        }
				if (empty($instance->sort_order)) {
		        $instance->sort_order=NULL;
		        }

				return $instance;
	    }	
	   
}