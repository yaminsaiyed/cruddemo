<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{

	   protected $table = 'cms_page';
	   public $primaryKey = 'id';
	   public $timestamps = true;
	   protected $fillable = ['title','short_description','long_description','meta_title','meta_description','meta_keyword','seo_keyword','status','sort_order']; 
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