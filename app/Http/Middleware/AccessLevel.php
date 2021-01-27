<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AccessLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $department = null)
    {

        if( Auth::user()->access_level == 'management' || Auth::user()->access_level == $department ){
            return $next($request);
        }else{
            return redirect('access_denied');
        }
    }
}
