<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Database\Eloquent\Model;
use App\PermissionRole;
use App\Permission;
class RolesAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        // get user role permissions
        $permission_role=PermissionRole::where('role_id',auth()->user()->role_id)->pluck('permission_id','permission_id');

        if (auth()->user()->role_id==1) {
          return $next($request);  
        }

        $permissions=Permission::all()->whereIn('id',$permission_role);
        // get requested action
        $actionName = class_basename($request->route()->getActionname());
        // check if requested action is in permissions list

        foreach ($permissions as $permission)
        {

         $_namespaces_chunks = explode('\\', $permission->controller);
         $controller = end($_namespaces_chunks);
         $controller . '@' . $permission->method;

         if ($actionName == $controller . '@' . $permission->method)
         {
            return $next($request);
           //authorized request
           
         }

        }

        // none authorized request
        //return response('Unauthorized Action', 403);
        return redirect()->route('setting.unauthorized');

    }
}
