<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

	   protected $table = 'roles';
	   public $primaryKey = 'id';
	   public $timestamps = true;
	   protected $fillable = ['name','description']; 
	   protected $guarded = array();

	   	public function get_permissionRole()
		{
			return $this->hasMany('App\PermissionRole', 'role_id','id');
		}
	   
}