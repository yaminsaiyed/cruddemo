<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{

	   protected $table = 'permission_role';
	   public $primaryKey = 'id';
	   public $timestamps = false;
	   protected $fillable = ['permission_id','role_id']; 
	   protected $guarded = array();

	   public function get_permissionData()
		{
			return $this->belongsTo('App\Permission', 'permission_id','id');
		}
	   
}