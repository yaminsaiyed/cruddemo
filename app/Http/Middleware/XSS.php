<?php

namespace App\Http\Middleware;

use Closure;

class XSS
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
        
        $input = $request->all();
        
        array_walk_recursive($input, function(&$input,$key) {
            if (!in_array($key, $this->xss_except_fields())) {
            $input = strip_tags($input);   
           }
            
        });
       
        $request->merge($input);
        return $next($request);

    }
    public static function xss_except_fields()
    {
        $except_fields_names=array(
            'long_description', 
            'footer_description', 
        );

        return $except_fields_names;
    }
}
