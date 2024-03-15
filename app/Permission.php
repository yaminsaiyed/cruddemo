<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

	   protected $table = 'permissions';
	   public $primaryKey = 'id';
	   public $timestamps = true;
	   protected $fillable = ['name','key','controller','method']; 
	   protected $guarded = array();

	   public function get_permissionRole()
		{
			return $this->hasMany('App\PermissionRole', 'permission_id','id');
		}
		
}