<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionRoleController extends Controller
{   
  public function __construct() {
        $this->middleware('auth',['except' => array()]);
    }
   function role_list()
  {	
  	$role_list=\App\Role::where('id','!=',1)->select('id','name','description')->get()->toArray();
  	return view('permission_role.role_list',['role_list'=>$role_list]);
  }
  function permission_update($role_id=0)
  {

    $permission=\App\Permission::select('id','name')->get()->unique('name')->toArray();
    $permission_array=array();
    foreach ($permission as $key => $permission_value) {
      $permission_array[$key]['parent']=$permission_value['name'];
      $permission_array[$key]['child']=\App\Permission::select('id','method')->where('name',$permission_value['name'])->get()->toArray();
    }
    $selected_permission_role=\App\PermissionRole::pluck('permission_id','permission_id')->toArray();
   	$role_details=\App\Role::where('id',$role_id)->select('id','name')->first()->toArray();

   	return view('permission_role.permission_update',['role_details'=>$role_details,'permission_array'=>$permission_array,'selected_permission_role'=>$selected_permission_role]);
  }

  function permission_update_submit(Request $request)
  {
    $role_id=$request->role_id;
   
    \App\PermissionRole::where('role_id',$role_id)->delete();
     if(isset($request->role_permission_id) && count($request->role_permission_id)>0) {
      
      foreach ($request->role_permission_id as $key => $value) {
        \App\PermissionRole::create(['role_id'=>$role_id,'permission_id'=>$value]);
      }

      return redirect()->route('permissionrole.role_list')->with('success_message', 'Data Successfully Submitted');   

    }
    
    
  }
}
